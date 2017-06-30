<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace cart\widgets;

use common\utils\ApplicationUtil;
/**
 * ConfirmCartSubView class file.
 * 
 * @package cart\widgets
 */
class ConfirmCartSubView extends CartSubView
{
    /**
     * inheritdoc
     */
    public $fullView = '/_cartdetails';
    
    /**
     * inheritdoc
     */
    public $itemView = '/_confirmitem';
    
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
}