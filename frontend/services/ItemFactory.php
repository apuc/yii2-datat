<?php


namespace frontend\services;


use Exception;
use frontend\models\data\BehaviorItem;
use frontend\models\data\Item;
use frontend\models\data\TraitItem;

/**
 * Class ItemFactory
 * @package frontend\services
 */
class ItemFactory
{
    const BY_TRAIT = 'trait';
    const BY_BEHAVIOR = 'behavior';


    /**
     * @param $type
     * @return Item
     * @throws Exception
     */
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