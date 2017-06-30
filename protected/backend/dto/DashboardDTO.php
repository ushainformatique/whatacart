<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace backend\dto;

/**
 * Data transfer object for dashboard
 *
 * @package backend\dto
 */
class DashboardDTO extends \usni\library\dto\BaseDTO
{
    /**
     * @var string 
     */
    private $_latestProducts;
    
    /**
     * @var string 
     */
    private $_latestUsers;
    
    /**
     * @var string 
     */
    private $_latestCustomers;
    
    /**
     * @var string 
     */
    private $_latestOrders;
    
    public function getLatestProducts()
    {
        return $this->_latestProducts;
    }

    public function setLatestProducts($latestProducts)
    {
        $this->_latestProducts = $latestProducts;
    }
    
    public function getLatestUsers()
    {
        return $this->_latestUsers;
    }

    public function setLatestUsers($latestUsers)
    {
        $this->_latestUsers = $latestUsers;
    }
    
    public function getLatestCustomers()
    {
        return $this->_latestCustomers;
    }

    public function getLatestOrders()
    {
        return $this->_latestOrders;
    }

    public function setLatestCustomers($latestCustomers)
    {
        $this->_latestCustomers = $latestCustomers;
    }

    public function setLatestOrders($latestOrders)
    {
        $this->_latestOrders = $latestOrders;
    }
}
