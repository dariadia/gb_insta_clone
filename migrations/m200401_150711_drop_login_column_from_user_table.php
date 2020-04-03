<?php

use yii\db\Migration;

/**
 * Handles dropping columns from table `{{%user}}`.
 */
class m200401_150711_drop_login_column_from_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('user', 'login');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
    }
}
