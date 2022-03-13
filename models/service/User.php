<?php

namespace app\models\db;

use Yii;

/**
 * This is the model class for table "users".
 *
 * @property int $id
 * @property string $first_name First name
 * @property string $last_name Last name
 * @property string $email Email
 * @property string $application Application
 * @property string $created_at Created At
 * @property string|null $updated_at Updated At
 * @property string|null $deleted_at Deleted At
 * @property int $is_deleted Is Deleted
 */
class User extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['first_name', 'last_name', 'email', 'application'], 'required'],
            [['created_at', 'updated_at', 'deleted_at'], 'safe'],
            [['is_deleted'], 'default', 'value' => null],
            [['is_deleted'], 'integer'],
            [['first_name', 'last_name', 'email', 'application'], 'string', 'max' => 255],
            [['email'], 'unique'],
            [['last_name'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'email' => 'Email',
            'application' => 'Application',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
            'is_deleted' => 'Is Deleted',
        ];
    }
}
