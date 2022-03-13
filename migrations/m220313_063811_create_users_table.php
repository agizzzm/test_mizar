<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%users}}`.
 */
class m220313_063811_create_users_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%users}}', [
            'id'          => $this->primaryKey(),
            'first_name'  => $this->string()->notNull()->comment('First name'),
            'last_name'   => $this->string()->notNull()->comment('Last name'),
            'email'       => $this->string()->notNull()->unique()->comment('Email'),
            'application' => $this->string()->notNull()->unique()->comment('Application'),
            'parent_id'   => $this->integer()->null()->comment('Parent User Id'),
            'created_at'  => $this->timestamp()->null()->comment('Created At'),
            'updated_at'  => $this->timestamp()->null()->comment('Updated At'),
            'deleted_at'  => $this->timestamp()->null()->comment('Deleted At'),
            'is_deleted'  => $this->tinyInteger(1)->notNull()->defaultValue(0)->comment('Is Deleted'),
        ]);

        $this->createIndex('users_parent_id_idx', '{{%users}}', 'parent_id');
        $this->createIndex('users_created_at_idx', '{{%users}}', 'created_at');
        $this->createIndex('users_updated_at_idx', '{{%users}}', 'updated_at');
        $this->createIndex('users_deleted_at_idx', '{{%users}}', 'deleted_at');
        $this->createIndex('users_is_deleted_idx', '{{%users}}', 'is_deleted');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%users}}');
    }
}
