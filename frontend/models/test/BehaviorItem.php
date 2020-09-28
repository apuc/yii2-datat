<?php


namespace frontend\models\test;


use frontend\behavior\KeyValueBehavior;

class BehaviorItem extends Item
{
    public function behaviors(): array
    {
        return [
            KeyValueBehavior::class
        ];
    }
}