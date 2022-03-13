<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%companies}}`.
 */
class m220312_133109_create_companies_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%companies}}', [
            'id'           => $this->primaryKey(),
            'name'         => $this->text()->notNull()->comment('Name'),
            'url'          => $this->text()->notNull()->unique()->comment('URL'),
            'access_token' => $this->text()->null()->comment('Token'),
            'created_at'   => $this->timestamp()->notNull()->defaultValue(new \yii\db\Expression('NOW()'))->comment('Created At'),
        ]);

        $this->createIndex('companies_created_at_idx', '{{%companies}}', 'created_at');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%companies}}');
    }
}
