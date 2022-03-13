<?php

namespace app\models\service;

use Yii;

class User extends \app\models\db\User
{
    const IS_DELETED = 1;
    const IS_NOT_DELETED = 0;

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
        $user->deleted_at = microtime(true);
        if (!$user->save()) {
            Yii::error(sprintf("user with id %s not found ", $userId));
            Yii::error(var_export($user->getErrors(), true));

            return false;
        }

        return true;
    }
}
