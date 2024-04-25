<?php

use yii\db\Migration;

/**
 * Class m240423_174814_image_table
 */
class m240423_174814_image_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('image', [
            'id' => $this->primaryKey(),
            'product_id' => $this->integer()->notNull(),
            'filename' => $this->string(255)->notNull(),
            'position' => $this->integer()->notNull()->defaultValue(0)
        ]);

        $this->createIndex(
            'idx-image-product_id',
            'image',
            'product_id'
        );

        $this->addForeignKey(
            'fk-image-product_id',
            'image',
            'product_id',
            'product',
            'id',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropTable('image');
    }
}
