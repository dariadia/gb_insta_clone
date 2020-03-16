<?php

use yii\db\Migration;

/**
 * Class m200316_144523_add_comments_table
 */
class m200316_144523_add_comments_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200316_144523_add_comments_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200316_144523_add_comments_table cannot be reverted.\n";

        return false;
    }
    */
}
