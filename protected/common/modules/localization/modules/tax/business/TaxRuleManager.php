<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace taxes\business;

use usni\library\business\Manager;
use yii\base\InvalidParamException;
use taxes\dao\ZoneDAO;
use usni\library\utils\ArrayUtil;
use taxes\dao\ProductTaxClassDAO;
use taxes\dao\TaxRuleDAO;
use usni\library\modules\auth\dao\AuthDAO;
use taxes\behaviors\TaxRuleBehavior;
/**
 * TaxRuleManager class file.
 * 
 * @package taxes\business
 */
class TaxRuleManager extends Manager
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TaxRuleBehavior::className()
        ];
    }
    
    /**
     * inheritdoc
     */
    public function getBrowseModels($modelClass)
    {
        return TaxRuleDAO::getAll($this->language);
    }
    
    /**
     * inheritdoc
     */
    public function loadModel($modelClass, $id)
    {
        $model  = TaxRuleDAO::getById($id, $this->language);
        if ($model === null)
        {
            throw new InvalidParamException("Id is not valid: $id");
        }
        $model['customer_groups']       = $this->getCustomerGroupByTaxRuleDetails($model['id']);
        $model['product_tax_classes']   = $this->getProductTaxClassByTaxRuleId($model['id']);
        $model['tax_zones']             = $this->getTaxZonesByTaxRuleId($id);
        return $model;
    }
    
    /**
     * Get tax zones for tax rule.
     * @param integer $id
     * @return string
     */
    public function getTaxZonesByTaxRuleId($id)
    {
        $records = ZoneDAO::getNameByTaxRuleId($id, $this->owner->language);
        if(!empty($records))
        {
            $zoneNames = [];
            foreach ($records as $record)
            {
                $zoneNames[] = $record['name'];
            }
            return implode(', ', $zoneNames);
        }
        return UsniAdaptor::t('application', '(not set)');
    }
    
    /**
     * inheritdoc
     */
    public function processEdit($formDTO)
    {
        parent::processEdit($formDTO);
        //Set product tax class dropdown data.
        $allProductTaxClassData = ProductTaxClassDAO::getAll($this->language);
        $productTaxClassData    = ArrayUtil::map($allProductTaxClassData, 'id', 'name');
        $formDTO->setProductTaxClassDropdownData($productTaxClassData);
        //Set zone dropdown data.
        $allZoneData    = ZoneDAO::getAll($this->language);
        $zoneData       = ArrayUtil::map($allZoneData, 'id', 'name');
        $formDTO->setTaxZonesDropdownData($zoneData);
        //Set customer groups.
        $customerGroupData = ArrayUtil::map(AuthDAO::getAllGroupsByCategory('customer'), 'id', 'name');
        $formDTO->setCustomerGroupsDropdownData($customerGroupData);
    }
}
