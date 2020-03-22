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
        /*
         * id SERIAL primary key,
	user_id BIGINT unsigned not null,
	media_id BIGINT unsigned not null,
	created_at DATETIME default current_timestamp,
	foreign key (user_id) references users(id),
	foreign key (media_id) references media(id)
         */
        $this->createTable('{{%likes}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull()->comment('Юзер, который поставил лайк'),
            'media_id' => $this->integer()->notNull()->comment('Медиа, которой поставили лайк'),
            'created_at' => $this->timestamp()->defaultExpression('now()'),
        ]);
        $this->addForeignKey(
            'fk_likes_media_id',
            '{{%likes}}',
            'media_id',
            '{{%media}}',
            'id');

        $this->addForeignKey(
            'fk_likes_author_id',
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
        $this->dropForeignKey('fk_likes_author_id', '{{%likes}}');
        $this->dropTable('{{%likes}}');
    }
}
