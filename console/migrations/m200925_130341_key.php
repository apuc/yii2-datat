<?php

use yii\db\Migration;

/**
 * Class m200925_130341_key
 */
class m200925_130341_key extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('key', [
            'id' => $this->primaryKey(),
            'slug' => $this->string()->notNull()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('key');
    }
}
