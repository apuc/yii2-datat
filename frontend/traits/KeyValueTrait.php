<?php


namespace frontend\traits;


use frontend\models\test\Key;
use frontend\models\test\KeyValue;

trait KeyValueTrait
{
    use KeyValueBaseTrait;


    public function setValue(string $key, string $value): void
    {
        $key_id = Key::getIdBySlug($key);
        if (KeyValue::getKeyValue($this->id, $key_id) !== null) {
            $this->setKeyValue($this->id, $key_id, $value);
        }
    }

    public function getValue(string $key): string
    {
        $key_id = Key::getIdBySlug($key);
        if (KeyValue::getKeyValue($this->id, $key_id) !== null) {
            return $this->getKeyValue($this->id, $key_id);
        }
    }
}