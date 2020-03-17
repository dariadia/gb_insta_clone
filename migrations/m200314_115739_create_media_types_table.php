<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%media_types}}`.
 */
class m200314_115739_create_media_types_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%media_types}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%media_types}}');
    }
}
