<?php

namespace frontend\traits;


use Exception;
use frontend\models\test\Item;
use frontend\models\test\Key;
use frontend\models\test\KeyValue;
use yii\base\Behavior;

trait KeyValueBaseTrait
{
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

    public function setKey(string $keySlug)
    {
        if (!Key::issetKey($keySlug)) {
            Key::createKey($keySlug);
        }
    }

    public function getKey(string $slug)
    {
        $key = Key::findOne(['slug' => $slug]);
        if ($key === null) {
            return null;
        }
        return $key;
    }

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

    public function getKeyValue($keyId)
    {
        return KeyValue::find()->where(['cur_item_id' => $this->getCurId(), 'key_id' => $keyId])->all();
    }

    public function setKeyValue($keyId, $value)
    {
        $keyVal = KeyValue::findOne(['cur_item_id' => $this->getCurId(), 'key_id' => $keyId]);
        $keyVal->value = $value;
        $keyVal->save();
        return $keyVal->id;
    }
}
