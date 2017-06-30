<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\shipping\business\free;

use common\modules\shipping\business\BaseShippingProcessor;
use usni\UsniAdaptor;
/**
 * Process business logic related to free shipping
 *
 * @package common\modules\shipping\business\free
 */
class ShippingProcessor extends BaseShippingProcessor
{   
    /**
     * @inheritdoc
     */
    public function getCalculatedPrice($cart)
    {
        return 0;
    }
    
    /**
     * @inheritdoc
     */
    public function getDescription()
    {
        return UsniAdaptor::t('shipping', 'Free Shipping');
    }
}