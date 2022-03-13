<?php

namespace app\controllers;

use app\models\helpers\StringHelper;
use app\models\service\User;
use Yii;
use yii\filters\AccessControl;
use yii\rest\ActiveController;
use yii\web\Response;
use app\models\service\Company;

class UserController extends ActiveController
{
    public $modelClass = 'app\models\service\User';

    public function behaviors()
    {
        return [
            'contentNegotiator' => [
                'class'   => 'yii\filters\ContentNegotiator',
                'formats' => [// Restful будет реагировать на разные форматы в соответствии с разными запросами клиентов
                    'application/json' => Response::FORMAT_JSON, // Установите здесь, чтобы открывать только JSON
                ],
            ],
            'access'            => [
                'class' => AccessControl::className(),
                'user'  => false,
                'rules' => [
                    [
                        'allow'         => true,
                        'matchCallback' => function ($rule, $action) {
                            $data = Yii::$app->getRequest()->getBodyParams();

                            if (isset($data['access_token'])) {
                                return Company::checkToken($data['access_token']);
                            }

                            return false;
                        },
                    ],
                ],
            ],
        ];
    }

    public function actionGetUser($id)
    {
        $user = User::getUser($id);
        if (empty($user) || $user->is_deleted == User::IS_DELETED) {
            return ['result' => 0, 'error' => "user not found"];
        }

        return ['result' => 1, 'user' => $user];
    }

    public function actionCreateUser()
    {
        $params = Yii::$app->getRequest()->getBodyParams();

        $requiredFields = ['first_name', 'last_name', 'email', 'application'];

        foreach ($requiredFields as $field) {
            if (!isset($params[$field]) || empty($params[$field])) {
                return ['result' => 0, 'error' => sprintf("%s is required field", $field)];
            }
        }

        foreach ($params as $paramName => &$param) {
            if ($paramName == 'email') {
                if (!filter_var($param, FILTER_VALIDATE_EMAIL)) {
                    return ['result' => 0, 'error' => "email is invalid"];
                }
            } elseif ($paramName == 'parent_id') {
                if (!filter_var($param, FILTER_VALIDATE_INT)) {
                    return ['result' => 0, 'error' => "parent is invalid"];
                }

                $parentUser = User::getUser($param);
                if (empty($parentUser)) {
                    return ['result' => 0, 'error' => "parent user not found"];
                }

                if (!empty($parentUser->parent_id)) {
                    return ['result' => 0, 'error' => "can't set parent user to current"];
                }

            } else {
                $param = StringHelper::filterString($param);
            }
        }

        $id = User::createUser($params);
        if (empty($id)) {
            return ['result' => 0, 'error' => "can't create user"];
        }

        return ['result' => 1, "userId" => $id];
    }

    public function actionDeleteUser($id)
    {
        $user = User::getUser($id);
        if (empty($user)) {
            return ['result' => 0, 'error' => "user not found"];
        }

        if (User::softDelete($id)) {
            return ['result' => 1];
        }

        return ['result' => 1, 'error' => "can't delete user"];
    }

    public function actionUpdateUser($id)
    {
        $user = User::getUser($id);
        if (empty($user) || $user->is_deleted == User::IS_DELETED) {
            return ['result' => 0, 'error' => "user not found"];
        }

        $params = Yii::$app->getRequest()->getBodyParams();

        $updateFields = ['first_name', 'last_name'];

        foreach ($params as $paramName => &$param) {
            if (!in_array($paramName, $updateFields)) {
                unset($params[$paramName]);
            }
            $param = StringHelper::filterString($param);
        }

        if (!User::updateUser($id, $params)) {
            return ['result' => 0, 'error' => "can't update user"];
        }

        return ['result' => 1];
    }
}
