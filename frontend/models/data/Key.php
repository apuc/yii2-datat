<?php

namespace frontend\models\data;

use Yii;

/**
 * This is the model class for table "key".
 *
 * @property int $id
 * @property string $slug
 *
 * @property KeyValue[] $keyValues
 */
class Key extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'key';
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
    public function getKeyValues()
    {
        return $this->hasMany(KeyValue::className(), ['key_id' => 'id']);
    }

    /**
     * @param string $slug
     * @param int|null $itemId
     * @return bool
     */
    public static function issetKey(string $slug)
    {
        $key = Key::findOne(['slug' => $slug]);
        if ($key !== null) {

            return true;
        }

        return false;
    }

    /**
     * @param string $slug
     * @return Key|null
     * @throws \Exception
     */
    public static function createKey(string $slug)
    {
        $key = new Key();
        $key->slug = $slug;
        if ($key->save()) {

            return $key;
        } else {
            throw new \Exception('Key can be saved');
        }
    }

    /**
     * @param string $slug
     * @return int
     */
    public static function getIdBySlug(string $slug): int
    {
        return self::findOne(['slug' => $slug])->id;
    }
}
