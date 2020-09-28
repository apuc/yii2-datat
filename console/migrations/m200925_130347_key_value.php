<?php

use yii\db\Migration;

/**
 * Class m200925_130347_key_value
 */
class m200925_130347_key_value extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('key_value', [
            'id' => $this->primaryKey(),
            'cur_item_id' => $this->integer()->notNull()->comment('Идентификатор текущего массива'),
            'children_item_id' => $this->integer()->comment('Идентификатор вложенного массива (если он есть)'),
            'key_id' => $this->integer()->notNull()->comment('Ссылка на ключ элемента массива'),
            'value' => $this->string()->comment('Значение элемента массива')
        ]);

        $this->addForeignKey(
            'key_value-cur_item_id',
            'key_value',
            'cur_item_id',
            'item',
            'id',
            'NO ACTION');

        $this->addForeignKey(
            'key_value-children_item_id',
            'key_value',
            'children_item_id',
            'item',
            'id',
            'NO ACTION');

        $this->addForeignKey(
            'key_value-key-id',
            'key_value',
            'key_id',
            'key',
            'id',
            'NO ACTION');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey(
            'key_value-cur_item_id',
            'key_value'
        );

        $this->dropForeignKey(
            'key_value-children_item_id',
            'key_value'
        );

        $this->dropForeignKey(
            'key_value-key-id',
            'key_value'
        );

        $this->dropTable('key_value');
    }
}
