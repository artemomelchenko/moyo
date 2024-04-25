<?php

use yii\db\Migration;

/**
 * Class m240423_174739_category_table
 */
class m240423_174739_category_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('category', [
            'id' => $this->primaryKey(),
            'title' => $this->string(255)->notNull(),
            'parent_id' => $this->integer()->null()->defaultValue(null)
        ]);

        $this->createIndex(
            'idx-category-parent_id',
            'category',
            'parent_id'
        );

        $this->addForeignKey(
            'fk-category-parent_id',
            'category',
            'parent_id',
            'category',
            'id',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropTable('category');
    }
}
