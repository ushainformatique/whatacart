<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\order\components\front;

use usni\library\components\BaseViewHelper;
/**
 * ViewHelper class file.
 *
 * @package order\components
 */
class ViewHelper extends BaseViewHelper
{
    /**
     * Order detail view
     * @var string 
     */
    public $orderDetailView      = 'common\modules\order\views\front\OrderDetailView';
    /**
     * Order history view
     * @var string 
     */
    public $orderHistoryView = 'common\modules\order\views\front\OrderHistoryView';
    /**
     * Order product view
     * @var string 
     */
    public $orderProductView = 'common\modules\order\views\front\ProductView';
    /**
     * My orders grid view
     * @var string 
     */
    public $myOrdersGridView = 'common\modules\order\views\front\MyOrdersGridView';
}
?>