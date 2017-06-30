<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\payment\traits;

use common\modules\payment\dao\PaymentDAO;
use usni\library\utils\ArrayUtil;
/**
 * Implement common functions related to payment
 *
 * @package common\modules\payment\traits
 */
trait PaymentTrait
{
    /**
     * Check if payment method allowed to deactivate.
     * @return boolean
     */
    public function checkIfPaymentMethodAllowedToDeactivate()
    {
        $tableBuildeClassName = $this->getTransactionTableBuilderClassName();
        $transactionModelClassName = $this->getTransactionModelClassName();
        if($this->checkDoesTableExist($tableBuildeClassName) == true)
        {
            $count = $transactionModelClassName::find()->count();
        }
        else
        {
            $count = 0;
        }
        if($count > 0)
        {
            return false;
        }
        return true;
    }
    
    /**
     * Check does table exists.
     * @param string $tableBuilderClassName
     * @return boolean
     */
    public function checkDoesTableExist($tableBuilderClassName)
    {
        $builderClassName   = str_replace('/', '\\', $tableBuilderClassName);
        $instance           = new $builderClassName();
        if($instance->doesTableExist($instance->getTableName()) == null)
        {
            return false;
        }
        return true;
    }
    
    /**
     * Get payment method name.
     * @param $type string
     * @param $language string
     * @return string
     */
    public function getPaymentMethodName($type, $language = null)
    {
        if($language == null)
        {
            $language = $this->language;
        }
        $data = $this->getPaymentMethodDropdown($language);
        return $data[$type];
    }
    
    /**
     * Get payment method dropdown.
     * @param $language string
     * @return array
     */
    public function getPaymentMethodDropdown($language = null)
    {
        if($language == null)
        {
            $language = $this->language;
        }
        $models = PaymentDAO::getPaymentMethods($language);
        return ArrayUtil::map($models, 'code', 'name');
    }
    
    /**
     * Get multiple mode payment method dropdown used on add payment screen in admin panel.
     * @return array $data
     */
    public function getMultipleModePaymentMethodDropdown()
    {
        $data            = [];
        $paymentDropdown = $this->getPaymentMethodDropdown();
        foreach($paymentDropdown as $code => $name)
        {
            $paymentManagerClassName    = '\common\modules\payment\business\\' . $code . '\AdminPaymentProcessor'; 
            $paymentManager             = new $paymentManagerClassName();
            if($paymentManager->isAllowedForMultipleModePayment() == true)
            {
                $data[$code] = $name;
            }
        }
        return $data;
    }
}
