<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace cart\dto;

use cart\models\Cart;
/**
 * CartDTO class file
 *
 * @package cart\dto
 */
class CartDTO extends \usni\library\dto\BaseDTO
{
    /**
     * @var Cart 
     */
    private $_cart;
    
    /**
     * @var int 
     */
    private $_qty;
    
    /**
     * @var array 
     */
    private $_inputOptions;
    
    /**
     * @var array 
     */
    private $_product;
    
    /**
     * @var array containing result while adding item to cart
     */
    private $_result;

    /**
     * @var array 
     */
    private $_postData;
    
    /**
     * @var int 
     */
    private $_customerId;
    
    /**
     * @return Cart
     */
    public function getCart()
    {
        return $this->_cart;
    }

    public function getQty()
    {
        return $this->_qty;
    }

    public function getInputOptions()
    {
        return $this->_inputOptions;
    }

    public function setCart($cart)
    {
        $this->_cart = $cart;
    }

    public function setQty($qty)
    {
        $this->_qty = $qty;
    }

    public function setInputOptions($inputOptions)
    {
        $this->_inputOptions = $inputOptions;
    }
    
    public function getProduct()
    {
        return $this->_product;
    }

    public function setProduct($product)
    {
        $this->_product = $product;
    }
    
    public function getResult()
    {
        return $this->_result;
    }

    public function setResult($result)
    {
        $this->_result = $result;
    }
    
    public function getPostData()
    {
        return $this->_postData;
    }

    public function setPostData($postData)
    {
        $this->_postData = $postData;
    }
    
    public function getCustomerId()
    {
        return $this->_customerId;
    }

    public function setCustomerId($customerId)
    {
        $this->_customerId = $customerId;
    }
}