<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%profiles}}`.
 */
class m200322_133640_create_profiles_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%profiles}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(50),
            'about' => $this->string(255),
            'site' => $this->string(255),
            'phone' => $this->string(30),
            'gender_id' => $this->tinyInteger()->defaultValue(0),
            'profile_photo' => $this->string(100),
            'user_id' => $this->integer()
        ]);

        $this->addForeignKey(
            'fk_profile_user_id',
            '{{profiles}}',
            'user_id',
            '{{user}}',
            'id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_profile_user_id', '{{profiles}}');

        $this->dropTable('{{%profiles}}');
    }
}
