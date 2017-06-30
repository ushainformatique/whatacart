<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace taxes\behaviors;

use usni\UsniAdaptor;
use taxes\utils\TaxUtil;
use customer\dao\CustomerDAO;
use taxes\dao\ProductTaxClassDAO;
/**
 * Implement common functions related to tax rule
 *
 * @package taxes\behaviors
 */
class TaxRuleBehavior extends \yii\base\Behavior
{
    /**
     * Gets based on display value.
     * @param mixed $model the data model
     * @return string
     */
    public function getBasedOnDisplayValue($model)
    {
        $value = TaxUtil::getBasedOnDisplayValue($model['based_on']);
        if(!empty($value))
        {
            return $value;
        }
        return UsniAdaptor::t('application', '(not set)');
    }
    
    /**
     * Gets customer group.
     * @param $id integer tax rule id
     * @return string
     */
    public function getCustomerGroupByTaxRuleDetails($id)
    {  
        $records = CustomerDAO::getCustomerGroupByTaxRuleDetails($id);
        if(!empty($records))
        {
            $customerGroupNames  = [];
            foreach ($records as $record)
            {
                $customerGroupNames[] = $record['name'];
            }
            return implode(', ', $customerGroupNames);
        }
        return UsniAdaptor::t('application', '(not set)');
    }
    
    /**
     * Get product tax class for tax rule.
     * @param integer $id tax rule id
     * @return string
     */
    public function getProductTaxClassByTaxRuleId($id)
    {
        $records = ProductTaxClassDAO::getNameByTaxRuleId($id, $this->owner->language);
        if(!empty($records))
        {
            $productTaxClassNames  = [];
            foreach ($records as $record)
            {
                $productTaxClassNames[] = $record['name'];
            }
            return implode(', ', $productTaxClassNames);
        }
        return UsniAdaptor::t('application', '(not set)');
    }
}
