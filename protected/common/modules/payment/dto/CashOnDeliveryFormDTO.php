<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\payment\dto;

use usni\library\dto\FormDTO;
/**
 * CashOnDeliveryFormDTO class file
 * 
 * @package common\modules\payment\dto
 */
class CashOnDeliveryFormDTO extends FormDTO
{
    /**
     * @var array 
     */
    private $_orderStatusDropdownData;
    
    public function getOrderStatusDropdownData()
    {
        return $this->_orderStatusDropdownData;
    }

    public function setOrderStatusDropdownData($orderStatusDropdownData)
    {
        $this->_orderStatusDropdownData = $orderStatusDropdownData;
    }
}
