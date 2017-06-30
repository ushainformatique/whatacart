<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\payment\business\paypal_standard;

/**
 * Paypal payment processor.
 * 
 * @package common\modules\payment\business\paypal_standard
 */
class PaymentProcessor extends \common\modules\payment\business\BaseSitePaymentProcessor
{   
    /**
     * @inheritdoc
     */
    public function processConfirm()
    {
        return true;
    }
}