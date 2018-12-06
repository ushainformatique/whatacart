<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace cart\models;

/**
 * Item class file
 *
 * @package cart\models
 */
class Item extends \yii\base\BaseObject
{
    /**
     * @var float 
     */
    private $_price;
    
    /**
     * @var float 
     */
    private $_optionsPrice;
    
    /**
     * @var string name of the product 
     */
    private $_name;
    
    /**
     * Is shipping required
     * @var int 
     */
    private $_requireShipping;
    
    /**
     * Displayed option str
     * @var string 
     */
    private $_displayedOptions;
    
    /**
     * Options data
     * @var string 
     */
    private $_optionsData;
    
    /**
     * Input options
     * @var array 
     */
    private $_inputOptions;
    
    /**
     * Product id
     * @var int 
     */
    private $_productId;
    
    /**
     * @var int 
     */
    private $_qty;
    
    /**
     * Product model
     * @var string 
     */
    private $_model;
    
    /**
     * Product thumbnail
     * @var string 
     */
    private $_thumbnail;
    
    /**
     * Code while adding it to cart
     * @var string 
     */
    private $_itemCode;
    
    /**
     * Stock status while adding item to cart
     * @var string 
     */
    private $_stockStatus;
    
    /**
     * Type of product added to cart
     * @var int 
     */
    private $_type;
    
    /**
     * @var float 
     */
    private $_tax;
    
    /**
     * @var float 
     */
    private $_totalPrice;

    public function getPrice()
    {
        return $this->_price;
    }

    public function getOptionsPrice()
    {
        return $this->_optionsPrice;
    }

    public function getName()
    {
        return $this->_name;
    }

    public function getRequireShipping()
    {
        return $this->_requireShipping;
    }

    public function getDisplayedOptions()
    {
        return $this->_displayedOptions;
    }

    public function getOptionsData()
    {
        return $this->_optionsData;
    }

    public function getInputOptions()
    {
        return $this->_inputOptions;
    }

    public function getProductId()
    {
        return $this->_productId;
    }

    public function getQty()
    {
        return $this->_qty;
    }

    public function getModel()
    {
        return $this->_model;
    }

    public function getThumbnail()
    {
        return $this->_thumbnail;
    }

    public function getItemCode()
    {
        return $this->_itemCode;
    }

    public function getStockStatus()
    {
        return $this->_stockStatus;
    }

    public function getType()
    {
        return $this->_type;
    }

    public function getTax()
    {
        return $this->_tax;
    }

    public function getTotalPrice()
    {
        return $this->_totalPrice;
    }

    public function setPrice($price)
    {
        $this->_price = $price;
    }

    public function setOptionsPrice($optionsPrice)
    {
        $this->_optionsPrice = $optionsPrice;
    }

    public function setName($name)
    {
        $this->_name = $name;
    }

    public function setRequireShipping($requireShipping)
    {
        $this->_requireShipping = $requireShipping;
    }

    public function setDisplayedOptions($displayedOptions)
    {
        $this->_displayedOptions = $displayedOptions;
    }

    public function setOptionsData($optionsData)
    {
        $this->_optionsData = $optionsData;
    }

    public function setInputOptions($inputOptions)
    {
        $this->_inputOptions = $inputOptions;
    }

    public function setProductId($productId)
    {
        $this->_productId = $productId;
    }

    public function setQty($qty)
    {
        $this->_qty = $qty;
    }

    public function setModel($model)
    {
        $this->_model = $model;
    }

    public function setThumbnail($thumbnail)
    {
        $this->_thumbnail = $thumbnail;
    }

    public function setItemCode($itemCode)
    {
        $this->_itemCode = $itemCode;
    }

    public function setStockStatus($stockStatus)
    {
        $this->_stockStatus = $stockStatus;
    }

    public function setType($type)
    {
        $this->_type = $type;
    }

    public function setTax($tax)
    {
        $this->_tax = $tax;
    }

    public function setTotalPrice($totalPrice)
    {
        $this->_totalPrice = $totalPrice;
    }
    
    public function toArray()
    {
        $record = [];
        $record['price'] = $this->getPrice(); 
        $record['optionsPrice'] = $this->getOptionsPrice(); 
        $record['name'] = $this->getName(); 
        $record['requireShipping'] = $this->getRequireShipping();
        $record['displayedOptions'] = $this->getDisplayedOptions();
        $record['optionsData']   = $this->getOptionsData();
        $record['inputOptions']  = $this->getInputOptions();
        $record['productId']     = $this->getProductId();
        $record['qty']           = $this->getQty();
        $record['model']         = $this->getProductId();
        $record['thumbnail']     = $this->getThumbnail();
        $record['itemCode']      = $this->getItemCode();
        $record['stockStatus']   = $this->getStockStatus();
        $record['type']          = $this->getType();
        $record['tax']           = $this->getTax();
        $record['totalPrice']    = $this->getTotalPrice();
        return $record;
    }
}