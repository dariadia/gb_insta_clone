<?php

use yii\db\Migration;

/**
 * Creates the comments table and foreign keys to media and users table
 * Class m200316_144523_create_comments_table
 */
class m200316_144523_create_comments_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%comments}}', [
            'id' => $this->primaryKey(),
            'author_id' => $this->integer()->notNull(),
            'media_id' => $this->integer()->notNull(),
            'comment' => $this->text()->notNull(),
            'created_at' => $this->timestamp()->defaultExpression('now()'),
            'updated_at' => $this->timestamp()->defaultExpression('now()'),
        ]);
        $this->addForeignKey(
            'fk_comments_media_id',
            '{{%comments}}',
            'media_id',
            '{{%media}}',
            'id');

        $this->addForeignKey(
            'fk_comments_author_id',
            '{{%comments}}',
            'author_id',
            '{{%user}}',
            'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_comments_media_id', '{{%comments}}');
        $this->dropForeignKey('fk_comments_author_id', '{{%comments}}');

        $this->dropTable('{{%comments}}');
    }

}
