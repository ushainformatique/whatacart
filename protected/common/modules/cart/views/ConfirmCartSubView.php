<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace cart\views;

use usni\UsniAdaptor;
use frontend\utils\FrontUtil;
use common\modules\shipping\utils\ShippingUtil;
use common\utils\ApplicationUtil;
/**
 * ConfirmCartSubView class file.
 * @package cart\views
 */
class ConfirmCartSubView extends CartSubView
{
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        if($this->cart->isShippingRequired())
        {
            //Shipping
            $model = ApplicationUtil::getCheckoutFormModel('deliveryOptionsEditForm');
            $this->shippingPrice  = ShippingUtil::getCalculatedPriceByType($model->shipping, $this->cart);
        }
    }
    
    /**
     * @inheritdoc
     */
    protected function getButtonViewFile()
    {
        return null;
    }
    
    /**
     * @inheritdoc
     */
    protected function getItemViewFile()
    {
        $frontTheme         = FrontUtil::getThemeName();
        return UsniAdaptor::getAlias('@themes/' . $frontTheme . '/views/cart/_confirmitem.php');
    }
}