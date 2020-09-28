<?php


namespace frontend\traits;


use frontend\models\data\Key;
use frontend\models\data\KeyValue;

/**
 * Trait KeyValueTrait
 * @package frontend\traits
 */
trait KeyValueTrait
{
    use KeyValueBaseTrait;

    /**
     * @param string $key
     * @param string $value
     * @throws \Exception
     */
    public function setValue(string $key, string $value): void
    {
        $key_id = Key::getIdBySlug($key);
        if (KeyValue::getKeyValue($this->id, $key_id) !== null) {
            $this->setKeyValue($this->id, $key_id, $value);
        }
    }

    /**
     * @param string $key
     * @return string
     * @throws \Exception
     */
    public function getValue(string $key): string
    {
        $key_id = Key::getIdBySlug($key);
        if (KeyValue::getKeyValue($this->id, $key_id) !== null) {
            return $this->getKeyValue($this->id, $key_id);
        }
    }
}