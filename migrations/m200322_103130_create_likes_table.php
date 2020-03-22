<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%likes}}`.
 */
class m200322_103130_create_likes_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%likes}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()
                ->unsigned()
                ->notNull()
                ->comment('Юзер, который поставил лайк'),
            'media_id' => $this->integer()
                ->unsigned()
                ->notNull()
                ->comment('Медиа, которой поставили лайк'),
            'created_at' => $this->timestamp()
                ->defaultExpression('now()'),
        ]);
        $this->addForeignKey(
            'fk_likes_media_id',
            '{{%likes}}',
            'media_id',
            '{{%media}}',
            'id');

        $this->addForeignKey(
            'fk_likes_user_id',
            '{{%likes}}',
            'user_id',
            '{{%user}}',
            'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_likes_media_id', '{{%likes}}');
        $this->dropForeignKey('fk_likes_user_id', '{{%likes}}');
        $this->dropTable('{{%likes}}');
    }
}
