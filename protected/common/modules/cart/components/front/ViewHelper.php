<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace cart\components\front;

use usni\library\components\BaseViewHelper;
/**
 * ViewHelper class file.
 *
 * @package cart\components\front
 */
class ViewHelper extends BaseViewHelper
{
    /**
     * Cart sub view
     * @var string 
     */
    public $cartSubView      = 'cart\views\CartSubView';
    
    /**
     * Confirm cart sub view
     * @var string 
     */
    public $confirmCartSubView    = 'cart\views\ConfirmCartSubView';
    
    /**
     * Complete order view
     * @var string 
     */
    public $completeOrderView     = 'cart\views\CompleteOrderView';
    
    /**
     * Payment method edit view
     * @var string 
     */
    public $paymentMethodEditView     = 'cart\views\PaymentMethodEditView';
    
    /**
     * Shopping cart detail view
     * @var string 
     */
    public $cartDetailView     = 'cart\views\DetailView';
}
?>