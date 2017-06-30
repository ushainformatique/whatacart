<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace common\modules\order\dto;

use common\modules\order\models\AdminCheckout;
use cart\models\AdminCart;
/**
 * AdminCheckoutDTO class file
 *
 * @package common\modules\order\dto
 */
class AdminCheckoutDTO extends \usni\library\dto\BaseDTO
{
    /**
     * @var AdminCheckout 
     */
    private $_checkout;
    
    /**
     * @var array 
     */
    private $_postData;
    
    /**
     * @var AdminCart 
     */
    private $_cart;
    
    /**
     * @var boolean 
     */
    private $_result;
    
    /**
     * @var array 
     */
    private $_shippingMethods;
    
    /**
     * @var array 
     */
    private $_paymentMethods;
    
    /**
     * @var string 
     */
    private $_interface;
    
    /**
     * @var array 
     */
    private $_customers;
    
    /**
     * @var array 
     */
    private $_products;
    
    /**
     * @var int 
     */
    private $_customerId;
    
    /**
     * @var array 
     */
    private $_browseModels;
    
    public function getCheckout()
    {
        return $this->_checkout;
    }

    public function getPostData()
    {
        return $this->_postData;
    }

    public function setCheckout($checkout)
    {
        $this->_checkout = $checkout;
    }

    public function setPostData($postData)
    {
        $this->_postData = $postData;
    }
    
    public function getCart()
    {
        return $this->_cart;
    }

    public function setCart($cart)
    {
        $this->_cart = $cart;
    }
    
    public function getResult()
    {
        return $this->_result;
    }

    public function setResult($result)
    {
        $this->_result = $result;
    }
    
    public function getShippingMethods()
    {
        return $this->_shippingMethods;
    }

    public function setShippingMethods($shippingMethods)
    {
        $this->_shippingMethods = $shippingMethods;
    }
    
    public function getPaymentMethods()
    {
        return $this->_paymentMethods;
    }

    public function setPaymentMethods($paymentMethods)
    {
        $this->_paymentMethods = $paymentMethods;
    }
    
    public function getInterface()
    {
        return $this->_interface;
    }

    public function setInterface($interface)
    {
        $this->_interface = $interface;
    }
    
    public function getCustomers()
    {
        return $this->_customers;
    }

    public function setCustomers($customers)
    {
        $this->_customers = $customers;
    }
    
    public function getProducts()
    {
        return $this->_products;
    }

    public function setProducts($products)
    {
        $this->_products = $products;
    }
    
    public function getCustomerId()
    {
        return $this->_customerId;
    }

    public function setCustomerId($customerId)
    {
        $this->_customerId = $customerId;
    }
    
    public function getBrowseModels()
    {
        return $this->_browseModels;
    }

    public function setBrowseModels($browseModels)
    {
        $this->_browseModels = $browseModels;
    }
}
