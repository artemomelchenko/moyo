<?php

use yii\db\Migration;

/**
 * Class m240423_174800_product_table
 */
class m240423_174800_product_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('product', [
            'id' => $this->primaryKey(),
            'title' => $this->string(255)->notNull(),
            'description' => $this->text(),
            'price' => $this->decimal(10,2)->notNull(),
            'price_discount' => $this->decimal(10,2),
            'quantity' => $this->integer()->notNull(),
            'category_id' => $this->integer()->notNull(),
            'created_at' => $this->dateTime()->notNull(),
            'updated_at' => $this->dateTime()->notNull()
        ]);

        $this->createIndex(
            'idx-product-category_id',
            'product',
            'category_id'
        );

        $this->addForeignKey(
            'fk-product-category_id',
            'product',
            'category_id',
            'category',
            'id',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropTable('product');
    }
}
