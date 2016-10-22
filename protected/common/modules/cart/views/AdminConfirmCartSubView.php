<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace cart\views;

use usni\UsniAdaptor;
use common\utils\ApplicationUtil;
use common\modules\shipping\utils\ShippingUtil;
/**
 * AdminConfirmCartSubView class file. This would be used on order confirm screen in admin
 * 
 * @package cart\views
 */
class AdminConfirmCartSubView extends AdminCartSubView
{
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        //Shipping
        if($this->cart->isShippingRequired())
        {
            $model = ApplicationUtil::getCheckoutFormModel('deliveryOptionsEditForm');
            $this->shippingPrice  = ShippingUtil::getCalculatedPriceByType($model->shipping, $this->cart);
        }
        else
        {
            $this->shippingPrice  = 0;
        }
    }
    
    /**
     * @inheritdoc
     */
    protected function getIsConfirm()
    {
        return true;
    }
    
    /**
     * @inheritdoc
     */
    protected function getItemViewFile()
    {
        return UsniAdaptor::getAlias('@common/modules/cart/views/_confirmCartItem.php');
    }
}