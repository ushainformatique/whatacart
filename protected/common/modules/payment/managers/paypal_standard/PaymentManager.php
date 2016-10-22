<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\payment\managers\paypal_standard;

/**
 * Paypal payment manager.
 * 
 * @package common\modules\payment\managers\paypal_standard
 */
class PaymentManager extends \common\modules\payment\managers\BaseFrontPaymentManager
{   
    /**
     * @inheritdoc
     */
    public function processConfirm()
    {
        return true;
    }
}