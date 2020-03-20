<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%media}}`.
 */
class m200314_122301_create_media_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%media}}', [
            'id' => $this->primaryKey(),
            'media_type_id' => $this->integer(),
            'user_id' => $this->integer(),
            'body' => $this->text(),
            'filename' => $this->string(255)->comment('Прикрепленный файл'),
            'size' => $this->integer(),
            'metadata' => $this->text()->comment('Сериализованные данные либо json'),
            'created_at' => $this->timestamp()->defaultExpression('now()')->notNull(),
            'updated_at' => $this->timestamp()->defaultExpression('now()')->notNull(),
        ]);

        $this->createIndex('media_user_index', '{{%media}}', 'user_id');

        $this->addForeignKey(
            'media_user_id_foreign_key',
            '{{%media}}',
            'user_id',
            '{{%user}}',
            'id'
        );
        $this->addForeignKey(
            'media_media_type_id_foreign_key',
            '{{%media}}',
            'media_type_id',
            '{{%media_types}}',
            'id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('media_user_id_foreign_key', '{{%media}}');
        $this->dropForeignKey('media_media_type_id_foreign_key', '{{%media}}');
        $this->dropTable('{{%media}}');
    }
}
