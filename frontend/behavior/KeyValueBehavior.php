<?php

namespace frontend\behavior;

use frontend\models\test\Key;
use frontend\models\test\KeyValue;
use frontend\traits\KeyValueBaseTrait;
use yii\base\Behavior;

class KeyValueBehavior extends Behavior
{
    use KeyValueBaseTrait;


    public function setValue(string $key, string $value): void
    {
        $key_id = Key::getIdBySlug($key);
        if (KeyValue::getKeyValue($this->owner->id, $key_id) !== null) {
            $this->setKeyValue($this->owner->id, $key_id, $value);
        }
    }

    public function getValue(string $key): string
    {
        $key_id = Key::getIdBySlug($key);
        if (KeyValue::getKeyValue($this->owner->id, $key_id) !== null) {
            return $this->getKeyValue($this->owner->id, $key_id);
        }
    }
}