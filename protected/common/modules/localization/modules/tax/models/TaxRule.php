<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace taxes\models;

use usni\library\db\TranslatableActiveRecord;
use usni\UsniAdaptor;
use taxes\models\TaxRuleDetails;
use usni\library\modules\users\models\User;
/**
 * TaxRule active record.
 * 
 * @package taxes\models
 */
class TaxRule extends TranslatableActiveRecord 
{
    const TAX_TYPE_PERCENT  = 'percent';
    const TAX_TYPE_FLAT     = 'flat';
    
    const TAX_BASED_ON_SHIPPING  = 'shipping';
    const TAX_BASED_ON_BILLING   = 'billing';
    
    /**
     * product tax class associated with the tax rule.
     * @var array
     */
    public $productTaxClass = array();
    
    /**
     * Customer groups associated with the tax rule.
     * @var array
     */
    public $customerGroups = array();
    
    /**
     * Tax zones associated with the tax rule.
     * @var array
     */
    public $taxZones = array();
    
	/**
     * @inheritdoc
     */
	public function rules()
	{
		return [
                    [['name', 'type', 'value', 'productTaxClass', 'customerGroups', 'taxZones', 'based_on'], 'required', 'except' => 'bulkedit'],
                    ['name',  'unique', 'targetClass' => TaxRuleTranslated::className(), 'targetAttribute' => ['name', 'language'], 'on' => 'create'],
                    ['name', 'unique', 'targetClass' => TaxRuleTranslated::className(), 'targetAttribute' => ['name', 'language'], 'filter' => ['!=', 'owner_id', $this->id], 'on' => 'update'],
                    ['name', 'string', 'max' => 64],
                    ['value', 'number']
               ];
	}

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        $scenario             = parent::scenarios();
        $commonAttributes     = ['name', 'based_on', 'productTaxClass', 'customerGroups', 'taxZones', 'type', 'value'];
        $scenario['create']   = $scenario['update'] = $commonAttributes;
        $scenario['bulkedit'] = ['based_on'];
        return $scenario;
    }
    
    /**
     * @inheritdoc
     */
	public function attributeLabels()
	{
		$labels = [
                        'name'                 => UsniAdaptor::t('application', 'Name'),
                        'productTaxClass'      => UsniAdaptor::t('tax', 'Product Tax Classes'),
                        'based_on'             => UsniAdaptor::t('tax', 'Based On'),
                        'customerGroups'       => UsniAdaptor::t('customer', 'Customer Groups'),
                        'type'				   => UsniAdaptor::t('application', 'Type'),
                        'value'                => UsniAdaptor::t('application', 'Value'),
                        'taxZones'             => UsniAdaptor::t('tax', 'Tax Zones')
                  ];
        return parent::getTranslatedAttributeLabels($labels);
	}

    /**
     * @inheritdoc
     */
    public static function getLabel($n = 1)
    {
        return ($n == 1) ? UsniAdaptor::t('tax', 'Tax Rule') : UsniAdaptor::t('tax', 'Tax Rules');
    }
    
    /**
     * @inheritdoc
     */
    public static function getTranslatableAttributes()
    {
        return ['name'];
    }
    
    /**
     * @inheritdoc
     */
    public function afterSave($insert, $changedAttributes)
    {
        if($this->scenario != 'bulkedit')
        {
            parent::afterSave($insert, $changedAttributes);
            if ($this->scenario == 'update')
            {
                TaxRuleDetails::deleteAll('tax_rule_id = :trid', [':trid' => $this->id]);
            }
            //Saving tax rule details.
            $productTaxClasses  = $this->productTaxClass;
            $customerGroups     = $this->customerGroups;
            $taxZones           = $this->taxZones;
            $taxRuleDetailsData = [];
            $isInstalled        = UsniAdaptor::app()->isInstalled();
            if($isInstalled)
            {
                $user   = UsniAdaptor::app()->user->getIdentity();
            }
            else
            {

                $user   = User::find()->where('id = :id', [':id' => User::SUPER_USER_ID])->asArray()->one();
            }

            foreach ($productTaxClasses as $productTaxClass)
            {
                foreach ($customerGroups as $customerGroup)
                {
                    foreach ($taxZones as $taxZone)
                    {
                        $taxRuleDetailsData[]   = [$this->id, $productTaxClass, $customerGroup, $taxZone,
                                                   $user['id'], $user['id'], date('Y-m-d H:i:s'), date('Y-m-d H:i:s')];
                    }
                }
            }
            $columns    = ['tax_rule_id', 'product_tax_class_id', 'customer_group_id', 'tax_zone_id', 'created_by', 'modified_by', 
                           'created_datetime', 'modified_datetime'];
            $table      = UsniAdaptor::tablePrefix() . 'tax_rule_details';
            try
            {
                UsniAdaptor::app()->db->createCommand()->batchInsert($table, $columns, $taxRuleDetailsData)->execute();
            }
            catch (\yii\db\Exception $e)
            {
                throw $e;
            }
        }
    }
    
    /**
     * @inheritdoc
     */
    public function afterFind()
    {
        parent::afterFind();
        $taxruleDetails = TaxRuleDetails::find()->where('tax_rule_id = :tri', [':tri' => $this->id])->asArray()->all();
        foreach ($taxruleDetails as $taxruleDetail)
        {
            $productTaxClass[]  = $taxruleDetail['product_tax_class_id'];
            $customerGroups[]   = $taxruleDetail['customer_group_id'];
            $taxZones[]         = $taxruleDetail['tax_zone_id'];
        }
        $this->productTaxClass  = array_values(array_unique($productTaxClass));
        $this->customerGroups   = array_values(array_unique($customerGroups));
        $this->taxZones         = array_values(array_unique($taxZones));
    }
    
    /**
     * Get product attributes.
     * @return \yii\db\ActiveQuery
     */
    public function getTaxRuleDetails()
    {
       return $this->hasMany(TaxRuleDetails::className(), ['tax_rule_id' => 'id']);
    }
    
    /**
     * @inheritdoc
     */
    public function beforeDelete()
    {
        if(parent::beforeDelete())
        {
            TaxRuleDetails::deleteAll('tax_rule_id = :trid', [':trid' => $this->id]);
            return true;
        }
        return false;
    }
}