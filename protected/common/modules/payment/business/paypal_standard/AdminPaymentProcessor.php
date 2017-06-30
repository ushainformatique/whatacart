<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\payment\business\paypal_standard;

/**
 * Paypal admin payment processor.
 * 
 * @package common\modules\payment\business\paypal_standard
 */
class AdminPaymentProcessor extends \common\modules\payment\business\BaseAdminPaymentProcessor
{   
    /**
     * inheritdoc
     */
    public function getPaymentActivityUrl($model)
    {
        return null;
    }
    
    /**
     * @inheritdoc
     */
    public function isAllowedForMultipleModePayment()
    {
        return false;
    }
}