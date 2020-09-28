<?php


namespace frontend\service;


use Exception;
use frontend\models\test\BehaviorItem;
use frontend\models\test\Item;
use frontend\models\test\TraitItem;

class ItemFactory
{
    const BY_TRAIT = 'trait';
    const BY_BEHAVIOR = 'behavior';


    public static function createItem($type): Item
    {
        switch ($type) {
            case self::BY_TRAIT:
                return new TraitItem();
            case self::BY_BEHAVIOR:
                return new BehaviorItem();
            default:
                throw new Exception('There is no such class');
        }
    }
}