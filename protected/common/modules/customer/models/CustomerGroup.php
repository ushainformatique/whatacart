<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace customer\models;

use usni\library\modules\auth\models\Group;
use customer\dao\CustomerDAO;
use usni\UsniAdaptor;
use yii\db\Exception;
use products\dao\SpecialDAO;
use taxes\dao\TaxRuleDAO;
use products\dao\DiscountDAO;
/**
 * CustomerGroup class file..
 *
 * @package customer\models
 */
class CustomerGroup extends Group
{
    /**
     * Type of group. By default it would be system
     * @var string 
     */
    public $type = 'customer';
    
    /**
     * inheritdoc
     */
    public function beforeDelete()
    {
        $isAllowedToDelete = $this->checkIfCustomerGroupAllowedToDelete();
        if($isAllowedToDelete == false)
        {
            throw new Exception('this group is associated with tax rule or customer or product discount or product special.');
        }
        return parent::beforeDelete();
    }
    
    /**
     * Check if customer group is allowed to delete.
     * @return boolean
     */
    public function checkIfCustomerGroupAllowedToDelete()
    {
        $language           = UsniAdaptor::app()->languageManager->selectedLanguage;
        $taxRules           = TaxRuleDAO::getTaxRuleByAttribute('customer_group_id', $this->id, $language);
        $customer           = CustomerDAO::getCustomerByGroupId($this->id);
        $productDiscounts   = DiscountDAO::getDiscountByAttribute('group_id', $this->id);
        $productSpecial     = SpecialDAO::getSpecialByAttribute('group_id', $this->id);
        if(empty($taxRules) && empty($customer) && empty($productDiscounts) && empty($productSpecial))
        {
            return true;
        }
        return false;
    }
    
    /**
     * inheritdoc
     */
    public static function tableName()
    {
       return UsniAdaptor::tablePrefix() . 'group';
    }
    
    /**
     * inheritdoc
     */
    public function updatePath()
    {
        $class  = Group::className();
        if($this->parent_id == 0)
        {
            $path = $this->id;
        }
        else
        {
            $row    = $class::find()->where(['id' => $this->parent_id])->asArray()->one();
            $path = $row['path'] . '/' . $this->id;
        }
        UsniAdaptor::app()->db->createCommand()->update(self::tableName(), ['path' => $path], 'id = :id', [':id' => $this->id])->execute();
    }
}