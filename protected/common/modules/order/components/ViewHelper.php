<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\order\components;

use usni\library\components\BaseViewHelper;
/**
 * ViewHelper class file.
 *
 * @package order\components
 */
class ViewHelper extends BaseViewHelper
{
    /**
     * Order grid view
     * @var string 
     */
    public $orderGridView    = 'common\modules\order\views\OrderGridView';
    /**
     * Invoice view
     * @var string 
     */
    public $invoiceView      = 'common\modules\order\views\invoice\InvoiceView';
    /**
     * Order history view
     * @var string 
     */
    public $orderHistoryView = 'common\modules\order\views\OrderHistoryView';
    /**
     * Order product view
     * @var string 
     */
    public $orderProductView = 'common\modules\order\views\ProductView';
}
?>