<?php

namespace app\models\service;

use Yii;

class User extends \app\models\db\User
{
    const IS_DELETED = 1;
    const IS_NOT_DELETED = 0;

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->created_at = date('Y/m/d h:i:s', time());
            }

            if (empty($this->is_deleted)) {
                $this->is_deleted = self::IS_NOT_DELETED;
            }

            return true;
        } else {
            return false;
        }
    }

    /**
     * @param string $userId
     * @return \app\models\db\User|null
     */
    public static function getUser(string $userId)
    {
        return self::find()->where(['id' => $userId])->one();
    }

    /**
     * @param array $params
     * @return int|null
     */
    public static function createUser(array $params)
    {
        $user = new User();
        if ($user->load($params, '') && $user->validate()) {
            if (!$user->save()) {
                Yii::error("can't create user because saving");
                Yii::error(var_export($user->getErrors(), true));

                return null;
            }
        } else {
            Yii::error("can't create user because validation");
            Yii::error(var_export($user->getErrors(), true));

            return null;
        }

        return $user->id;
    }

    /**
     * @param $userId
     * @return bool
     */
    public static function softDelete($userId)
    {
        /** @var $user \app\models\service\User */
        $user = self::find()->where(['id' => $userId])->one();
        if (empty($user)) {
            Yii::error(sprintf("user with id %s not found ", $userId));

            return false;
        }

        $user->is_deleted = self::IS_DELETED;
        $user->deleted_at = date('Y/m/d h:i:s', time());
        if (!$user->save()) {
            Yii::error(sprintf("user with id %s not found ", $userId));
            Yii::error(var_export($user->getErrors(), true));

            return false;
        }

        return true;
    }

    /**
     * @param string $userId
     * @param array $params
     * @return bool
     */
    public static function updateUser(string $userId, array $params)
    {
        $user = self::getUser($userId);

        if ($user->load($params, '') && $user->validate()) {
            if (!$user->save()) {
                Yii::error("can't update user because saving");
                Yii::error(var_export($user->getErrors(), true));

                return false;
            }
        } else {
            Yii::error("can't update user because validation");
            Yii::error(var_export($user->getErrors(), true));

            return false;
        }

        return true;
    }
}
