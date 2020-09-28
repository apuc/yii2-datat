<?php

namespace frontend\traits;


use Exception;
use frontend\models\data\Key;
use frontend\models\data\KeyValue;
use yii\base\Behavior;

/**
 * Trait KeyValueBaseTrait
 * @package frontend\traits
 */
trait KeyValueBaseTrait
{
    /**
     * @param array $keyValues
     * @param string|null $children_item_id
     * @throws Exception
     */
    public function setKeyValues(array $keyValues, string $children_item_id = null)
    {
        if ($keyValues === null) {
            throw new Exception('Items can be null');
        }
        if (count($keyValues) === 0) {
            throw new Exception('Count items can be equal zero');
        }

        foreach ($keyValues as $key => $value) {
            $this->setKey($key);
            $keyValue = new KeyValue();
            $keyValue->key_id = $this->getKey($key)->id;
            $keyValue->value = $value;
            $keyValue->cur_item_id = $this->getCurId();
            if ($children_item_id !== null) {
                if ($keyValue->cur_item_id === $children_item_id) {
                    throw new Exception('Item cannot be children to itself');
                }
                $keyValue->children_item_id = $children_item_id;
            }
            $keyValue->save();
            if ($keyValue->id === null) {
                throw new Exception("$key was not saved");
            }
        }
    }

    /**
     * @param string $keySlug
     * @throws Exception
     */
    public function setKey(string $keySlug)
    {
        if (!Key::issetKey($keySlug)) {
            Key::createKey($keySlug);
        }
    }

    /**
     * @param string $slug
     * @return Key|null
     */
    public function getKey(string $slug)
    {
        return $key = Key::findOne(['slug' => $slug]);
    }

    /**
     * @return mixed|null
     * @throws Exception
     */
    private function getCurId()
    {
        $id = null;
        if ($this instanceof Behavior) {
            $id = $this->owner->id;
        } else {
            $id = $this->id;
        }
        if ($id === null) {
            throw new Exception('Object does not has ID');
        }

        return $id;
    }

    /**
     * @param $keyId
     * @return array|\yii\db\ActiveRecord[]
     * @throws Exception
     */
    public function getKeyValue($keyId)
    {
        return KeyValue::find()->where(['cur_item_id' => $this->getCurId(), 'key_id' => $keyId])->all();
    }

    /**
     * @param $keyId
     * @param $value
     * @return array|int
     * @throws Exception
     */
    public function setKeyValue($keyId, $value)
    {
        $keyVal = KeyValue::findOne(['cur_item_id' => $this->getCurId(), 'key_id' => $keyId]);
        $keyVal->value = $value;
        if ($keyVal->save()) {

            return $keyVal->id;
        } else {

            return $keyVal->errors;
        }
    }
}
