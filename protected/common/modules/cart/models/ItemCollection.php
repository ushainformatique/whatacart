<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace cart\models;

use yii\base\BaseObject;
use cart\models\Item;
use ArrayIterator;
/**
 * ItemColelction class file
 *
 * @package cart\models
 */
class ItemCollection extends BaseObject implements \IteratorAggregate, \ArrayAccess, \Countable
{
    /**
     * @var Item[] the items in this collection (indexed by the item item code)
     */
    private $_items = [];
    
    /**
     * Constructor.
     * @param array $items the items that this collection initially contains. This should be
     * an array of name-value pairs.
     * @param array $config name-value pairs that will be used to initialize the object properties
     */
    public function __construct($items = [], $config = [])
    {
        $this->_items = $items;
        parent::__construct($config);
    }
    
    /**
     * Returns an iterator for traversing the items in the collection.
     * This method is required by the SPL interface [[\IteratorAggregate]].
     * It will be implicitly called when you use `foreach` to traverse the collection.
     * @return ArrayIterator an iterator for traversing the items in the collection.
     */
    public function getIterator()
    {
        return new ArrayIterator($this->_items);
    }

    /**
     * Returns the number of items in the collection.
     * This method is required by the SPL `Countable` interface.
     * It will be implicitly called when you use `count($collection)`.
     * @return integer the number of items in the collection.
     */
    public function count()
    {
        return $this->getCount();
    }

    /**
     * Returns the number of items in the collection.
     * @return integer the number of items in the collection.
     */
    public function getCount()
    {
        return count($this->_items);
    }

    /**
     * Returns the item with the specified name.
     * @param string $itemCode the item code
     * @return Item the item with the specified code. Null if the item code does not exist.
     */
    public function get($itemCode)
    {
        return isset($this->_items[$itemCode]) ? $this->_items[$itemCode] : null;
    }

    /**
     * Returns whether there is a item with the specified code.
     * @param string $itemCode the item code
     * @return boolean whether the item with code exists
     * @see remove()
     */
    public function has($itemCode)
    {
        return isset($this->_items[$itemCode]);
    }

    /**
     * Adds an item to the collection.
     * If there is already an item with the same code in the collection, it will be removed first.
     * @param Item $item the item to be added
     */
    public function add($item)
    {
        $this->_items[$item->getItemCode()] = $item;
    }

    /**
     * Removes an item.
     * @param Item $item the item to be removed.
     */
    public function remove($item)
    {
        unset($this->_items[$item->getItemCode()]);
    }

    /**
     * Removes all items.
     */
    public function removeAll()
    {
        $this->_items = [];
    }

    /**
     * Returns the collection as a PHP array.
     * @return array the array representation of the collection.
     * The array keys are item name, and the array values are the corresponding item objects.
     */
    public function toArray()
    {
        return $this->_items;
    }

    /**
     * Populates the item collection from an array.
     * @param array $array the items to populate from
     */
    public function fromArray(array $array)
    {
        $this->_items = $array;
    }

    /**
     * Returns whether there is a item with the specified code.
     * This method is required by the SPL interface [[\ArrayAccess]].
     * It is implicitly called when you use something like `isset($collection[$name])`.
     * @param string $itemCode the item code
     * @return boolean whether the item with code exists
     */
    public function offsetExists($itemCode)
    {
        return $this->has($itemCode);
    }

    /**
     * Returns the item with the specified code.
     * This method is required by the SPL interface [[\ArrayAccess]].
     * It is implicitly called when you use something like `$item = $collection[$itemCode];`.
     * This is equivalent to [[get()]].
     * @param string $itemCode the item code
     * @return Item the item with the specified code, null if the item code does not exist.
     */
    public function offsetGet($itemCode)
    {
        return $this->get($itemCode);
    }

    /**
     * Adds the item to the collection.
     * This method is required by the SPL interface [[\ArrayAccess]].
     * It is implicitly called when you use something like `$collection[$name] = $item;`.
     * This is equivalent to [[add()]].
     * @param string $itemCode the item code
     * @param Item $item the item to be added
     */
    public function offsetSet($itemCode, $item)
    {
        $this->add($item);
    }

    /**
     * Removes the item code.
     * This method is required by the SPL interface [[\ArrayAccess]].
     * It is implicitly called when you use something like `unset($collection[$itemCode])`.
     * This is equivalent to [[remove()]].
     * @param string $itemCode the item code
     */
    public function offsetUnset($itemCode)
    {
        $this->remove($itemCode);
    }
    
    /**
     * Returns the collection of items as array with each Item object as an array itself
     * @return array
     */
    public function asArray()
    {
        $records    = [];
        $rows       = $this->toArray();
        foreach($rows as $itemCode => $item)
        {
           $records[$itemCode] = $item->toArray();
        }
        return $records;
    }
}