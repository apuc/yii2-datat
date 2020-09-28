<?php

namespace frontend\models\test;

use Yii;
use yii\db\Exception;

/**
 * This is the model class for table "item".
 *
 * @property int $id
 * @property string $slug
 *
 * @property KeyValue[] $keyValues
 * @property KeyValue[] $keyValuesChildren
 */
class Item extends \yii\db\ActiveRecord
{
    const NUM_SYM_SLUG = 20;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'item';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['slug'], 'required'],
            [['slug'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'slug' => 'Slug',
        ];
    }

    /**
     * Gets query for [[KeyValues]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCurrentKeyValues()
    {
        return $this->hasMany(KeyValue::className(), ['children_item_id' => 'id']);
    }

    /**
     * Gets query for [[KeyValuesChildren]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getKeyValuesChildren()
    {
        return $this->hasMany(KeyValue::className(), ['cur_item_id' => 'id']);
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                if ($this->slug !== null) {
                    if (self::getItemBySlug($this->slug) === null) {
                        return true;
                    } else {
                        throw new Exception('The slug exist already');
                    }
                } else {
                    throw new Exception('The slug is null');
                }
            }
        }

        return false;
    }

    /**
     * @param string $slug
     * @return Item
     * @throws Exception
     */
    public static function createItem(string $slug)
    {
        $item = new Item();
        $item->slug = $slug;
        $item->save();
        if ($item->id === null) {
            throw new Exception('item can be saved');
        }

        return $item;
    }

    public static function getItemBySlug(string $slug)
    {
        return self::findOne(['slug' => $slug]);
    }
}
