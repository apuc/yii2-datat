<?php


namespace frontend\models\data;


use frontend\behavior\KeyValueBehavior;

/**
 * Class BehaviorItem
 * @package frontend\models\data
 */
class BehaviorItem extends Item
{
    /**
     * @return array
     */
    public function behaviors(): array
    {
        return [
            KeyValueBehavior::class
        ];
    }
}