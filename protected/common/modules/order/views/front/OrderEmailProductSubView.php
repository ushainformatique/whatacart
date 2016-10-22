<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\order\views\front;

use common\modules\order\views\AdminOrderProductSubView;
use usni\UsniAdaptor;
/**
 * OrderEmailProductSubView class file. This would be used while sending email related to order
 * @package common\modules\order\views\front
 */
class OrderEmailProductSubView extends AdminOrderProductSubView
{
    /**
     * @inheritdoc
     */
    protected function getItemViewFile()
    {
        return UsniAdaptor::getAlias('@common/modules/order/views/_orderEmailItem.php');
    }
    
    /**
     * @inheritdoc
     */
    protected function getFullViewFile()
    {
        return UsniAdaptor::getAlias('@common/modules/order/views/_orderEmailProductDetails.php');
    }
}