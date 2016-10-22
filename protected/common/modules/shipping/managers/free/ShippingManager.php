<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\shipping\managers\free;

use common\modules\shipping\managers\BaseShippingManager;
use usni\UsniAdaptor;
/**
 * Loads default data related to shipping.
 *
 * @package common\modules\shipping\managers\free
 */
class ShippingManager extends BaseShippingManager
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
    public function getDescription($language = null)
    {
        return UsniAdaptor::t('shipping', 'Free Shipping');
    }
}
?>