<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace common\modules\payment\dto;

use common\modules\order\models\Order;
/**
 * Data transfer object for payment
 *
 * @package common\modules\payment\dto
 */
class TransactionFormDTO extends \usni\library\dto\FormDTO
{
    /**
     * @var Order 
     */
    private $_order;
    
    public function getOrder()
    {
        return $this->_order;
    }

    public function setOrder($order)
    {
        $this->_order = $order;
    }
}
