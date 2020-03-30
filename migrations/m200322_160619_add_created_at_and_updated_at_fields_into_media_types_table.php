<?php

use yii\db\Migration;

/**
 * Class m200322_160619_add_created_at_and_updated_at_fields_into_media_types_table
 */
class m200322_160619_add_created_at_and_updated_at_fields_into_media_types_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('media_types', 'created_at', $this->timestamp()->defaultExpression('now()'));
        $this->addColumn('media_types', 'updated_at', $this->timestamp()->defaultExpression('now()'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('media_types', 'created_at');
        $this->dropColumn('media_types', 'updated_at');
    }
}
