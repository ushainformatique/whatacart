<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\order\widgets\front;

use common\modules\order\widgets\AdminOrderProductSubView;
use common\modules\order\behaviors\OrderEmailProductSubViewBehavior;
/**
 * OrderEmailProductSubView class file. This would be used while sending email related to order.
 * 
 * @package common\modules\order\widgets\front
 */
class OrderEmailProductSubView extends AdminOrderProductSubView
{
    /**
     * @inheritdoc
     */
    public $fullView = '@common/modules/order/views/email/_orderEmailProductDetails.php';
    
    /**
     * @inheritdoc
     */
    public $itemView = '@common/modules/order/views/email/_orderEmailItem.php';
    
    /**
     * inheritdoc
     */
    public function behaviors()
    {
        return [
                    OrderEmailProductSubViewBehavior::className()
               ];
    }
}