<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\payment\components;

/**
 * AdminPaymentFactory class file.
 * 
 * @package common\modules\payment\components
 */
class AdminPaymentFactory extends PaymentFactory
{
    /**
     * @inheritdoc
     */
    public function getInstance()
    {
        $className  = '\common\modules\payment\business\\' . $this->type . '\AdminPaymentProcessor'; 
        return new $className($this->getInstanceConfig());
    }
}