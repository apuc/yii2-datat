<?php

namespace frontend\models\test;

/**
 * This is the model class for table "key_value".
 *
 * @property int $id
 * @property int $cur_item_id Идентификатор текущего массива
 * @property int|null $children_item_id Идентификатор вложенного массива (если он есть)
 * @property int $key_id Ссылка на ключ элемента массива
 * @property string|null $value Значение элемента массива
 *
 * @property Item $childrenItem
 * @property Item $curItem
 * @property Key $key
 */
class KeyValue extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'key_value';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cur_item_id', 'key_id'], 'required'],
            [['cur_item_id', 'children_item_id', 'key_id'], 'integer'],
            [['value'], 'string', 'max' => 255],
            [['children_item_id'], 'exist', 'skipOnError' => true, 'targetClass' => Item::className(), 'targetAttribute' => ['children_item_id' => 'id']],
            [['cur_item_id'], 'exist', 'skipOnError' => true, 'targetClass' => Item::className(), 'targetAttribute' => ['cur_item_id' => 'id']],
            [['key_id'], 'exist', 'skipOnError' => true, 'targetClass' => Key::className(), 'targetAttribute' => ['key_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'cur_item_id' => 'Cur Item ID',
            'children_item_id' => 'Children Item ID',
            'key_id' => 'Key ID',
            'value' => 'Value',
        ];
    }

    /**
     * Gets query for [[ChildrenItem]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getChildrenItem()
    {
        return $this->hasOne(Item::className(), ['id' => 'children_item_id']);
    }

    /**
     * Gets query for [[CurItem]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCurItem()
    {
        return $this->hasOne(Item::className(), ['id' => 'cur_item_id']);
    }

    /**
     * Gets query for [[Key]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getKey()
    {
        return $this->hasOne(Key::className(), ['id' => 'key_id']);
    }

    public static function getKeyValue($curItemId, $slug)
    {
        $key = Key::findOne(['slug' => $slug]);
        return KeyValue::find()->where(['cur_item_id' => $curItemId, 'key_id' => $key->id])->all();
    }
}
