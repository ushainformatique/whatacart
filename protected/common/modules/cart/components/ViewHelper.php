<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace cart\components;

use usni\library\components\BaseViewHelper;
/**
 * ViewHelper class file.
 *
 * @package cart\components
 */
class ViewHelper extends BaseViewHelper
{
    /**
     * Cart sub view
     * @var string 
     */
    public $cartSubView      = 'cart\views\CartSubView';
    
    /**
     * Payment method edit view
     * @var string 
     */
    public $paymentMethodEditView     = 'cart\views\PaymentMethodEditView';
}
?>