<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace taxes\models;

use usni\library\components\UiBaseActiveRecord;
use usni\UsniAdaptor;
use usni\library\modules\auth\models\Group;
use taxes\models\ProductTaxClass;
/**
 * TaxRuleDetails active record.
 * @package taxes\models
 */
class TaxRuleDetails extends UiBaseActiveRecord 
{
	/**
     * @inheritdoc
     */
	public function rules()
	{
		return [
                    [['tax_rule_id', 'product_tax_class_id', 'customer_group_id', 'tax_rate_id'], 'required'],
                    [['tax_rule_id', 'product_tax_class_id', 'customer_group_id', 'tax_rate_id'], 'number', 'integerOnly' => true],
                    [['tax_rule_id', 'product_tax_class_id', 'customer_group_id', 'tax_rate_id'], 'safe'],
               ];
	}

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        $scenario             = parent::scenarios();
        $scenario['create']   = $scenario['update'] = ['tax_rule_id', 'product_tax_class_id', 'customer_group_id', 'tax_rate_id'];
        $scenario['bulkedit'] = ['tax_rule_id', 'product_tax_class_id', 'customer_group_id'];
        return $scenario;
    }
    
    /**
     * @inheritdoc
     */
	public function attributeLabels()
	{
		$labels = [
                        'product_tax_class_id' => UsniAdaptor::t('tax', 'Product Tax Classes'),
                        'customer_group_id'    => UsniAdaptor::t('customer', 'Customer Groups'),
                        'tax_rate'             => UsniAdaptor::t('tax', 'Tax Rate'),
                        'type'                 => UsniAdaptor::t('application', 'Type'),
                  ];
        return parent::getTranslatedAttributeLabels($labels);
	}

    /**
     * @inheritdoc
     */
    public static function getLabel($n = 1)
    {
        return ($n == 1) ? UsniAdaptor::t('tax', 'Tax Rule Detail') : UsniAdaptor::t('tax', 'Tax Rule Details');
    }
    
    /**
     * Get customer group for the tax rule.
     * @return ActiveQuery
     */
    public function getCustomerGroup()
    {
        return $this->hasOne(Group::className(), ['id' => 'customer_group_id']);
    }
    
    /**
     * Get product tax class for the tax rule.
     * @return ActiveQuery
     */
    public function getProductTaxClass()
    {
        return $this->hasOne(ProductTaxClass::className(), ['id' => 'product_tax_class_id']);
    }
    
    /**
     * Get tax rule.
     * @return ActiveQuery
     */
    public function getTaxRule()
    {
        return $this->hasOne(TaxRule::className(), ['id' => 'tax_rule_id']);
    }
    
    /**
     * Get tax rates for the rule.
     * @return ActiveQuery
     */
    public function getTaxRates()
    {
        //Read it as select * from taxrate, taxruledetails where taxrate.id = taxruledetails.tax_rate_id  AND taxruledetails.tax_rule_id = taxrule.id
        //Thus when via is used second param in the link correspond to via column in the relation.
        return $this->hasMany(TaxRate::className(), ['id' => 'tax_rate_id']);
    }
}