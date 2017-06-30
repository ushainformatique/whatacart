<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\order\widgets;

use common\utils\ApplicationUtil;
/**
 * AdminConfirmCartSubView class file. This would be used on order confirm screen in admin
 * 
 * @package common\modules\order\widgets
 */
class AdminConfirmCartSubView extends AdminCartSubView
{
    /**
     * inheritdoc
     */
    public $itemView = '/_confirmCartItem';
    
    /**
     * @var boolean is rendered on confirm screen
     */
    public $isConfirm = true;
    
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        if($this->cart->isShippingRequired())
        {
            //Shipping
            $model                      = ApplicationUtil::getCheckoutFormModel('deliveryOptionsEditForm');
            $this->shippingPrice        = $model->shipping_fee;
        }
    }
    
    /**
     * @inheritdoc
     */
    public function getCurrencyCode()
    {
        $checkout = ApplicationUtil::getCheckout();
        return $checkout->customerForm->currencyCode;
    }
}