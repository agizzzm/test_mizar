<?php

namespace app\models\db;

use Yii;

/**
 * This is the model class for table "companies".
 *
 * @property int $id
 * @property string $name Name
 * @property string $url URL
 * @property string|null $access_token Token
 * @property string $created_at Created At
 */
class Company extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'companies';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'url'], 'required'],
            [['name', 'url', 'access_token'], 'string'],
            [['created_at'], 'safe'],
            [['url'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'url' => 'Url',
            'access_token' => 'Access Token',
            'created_at' => 'Created At',
        ];
    }
}
