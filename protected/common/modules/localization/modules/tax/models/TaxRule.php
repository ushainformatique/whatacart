<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace taxes\models;

use usni\library\components\TranslatableActiveRecord;
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
     * Tax rate associated with the tax rule.
     * @var string
     */
    public $taxRates = array();
    
    /**
     * Customer groups associated with the tax rule.
     * @var array
     */
    public $customerGroups = array();
    
	/**
     * @inheritdoc
     */
	public function rules()
	{
		return [
                    [['name', 'based_on'], 'required', 'except' => 'bulkedit'],
                    ['name',  'unique', 'targetClass' => TaxRuleTranslated::className(), 'targetAttribute' => ['name', 'language'], 'on' => 'create'],
                    ['name', 'unique', 'targetClass' => TaxRuleTranslated::className(), 'targetAttribute' => ['name', 'language'], 'filter' => ['!=', 'owner_id', $this->id], 'on' => 'update'],
                    [['productTaxClass', 'taxRates', 'customerGroups'], 'required'],
                    ['name', 'string', 'max' => 64],
               ];
	}

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        $scenario             = parent::scenarios();
        $scenario['create']   = $scenario['update'] = ['name', 'based_on', 'tax_zone_id', 'productTaxClass', 'taxRates', 'customerGroups'];
        $scenario['bulkedit'] = ['based_on', 'tax_zone_id'];
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
                        'taxRate'              => UsniAdaptor::t('tax', 'Tax Rate')
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
            $taxRateIds         = $this->taxRates;
            $customerGroups     = $this->customerGroups;
            $taxRuleDetailsData = [];
            $isInstalled        = UsniAdaptor::app()->isInstalled();
            if($isInstalled)
            {
                $user   = UsniAdaptor::app()->user->getUserModel();
            }
            else
            {

                $user   = User::find()->where('id = :id', [':id' => User::SUPER_USER_ID])->asArray()->one();
            }

            foreach ($productTaxClasses as $productTaxClass)
            {
                foreach ($taxRateIds as $taxRateId)
                {
                    $taxRate    = TaxRate::find()->where('id = :id', [':id' => $taxRateId])->asArray()->one();
                    foreach ($customerGroups as $customerGroup)
                    {

                        $taxRuleDetailsData[]   = [$this->id, $productTaxClass, $customerGroup, $taxRateId, $taxRate['tax_zone_id'], 
                                                   $user['id'], date('Y-m-d H:i:s'), $user['id'], date('Y-m-d H:i:s')];
                    }
                }
            }
            $columns    = ['tax_rule_id', 'product_tax_class_id', 'customer_group_id', 'tax_rate_id', 'tax_zone_id', 'created_by', 'created_datetime', 
                           'modified_by', 'modified_datetime'];
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
            $this->productTaxClass[]  = $taxruleDetail['product_tax_class_id'];
            $this->customerGroups[]   = $taxruleDetail['customer_group_id'];
            $this->taxRates[]         = $taxruleDetail['tax_rate_id'];
        }
    }
    
    /**
     * Get product tax class for tax rule.
     * return string
     */
    public function renderProductTaxClass()
    {
        $productTaxClassTable       = UsniAdaptor::tablePrefix() . 'product_tax_class';
        $trProductTaxClassTable     = UsniAdaptor::tablePrefix() . 'product_tax_class_translated';
        $taxRuleDetailsTable        = UsniAdaptor::tablePrefix() . 'tax_rule_details';
        $language       = UsniAdaptor::app()->languageManager->getContentLanguage();
        $sql            = "SELECT DISTINCT tptt.name
                               FROM $productTaxClassTable tpt,  $trProductTaxClassTable tptt, $taxRuleDetailsTable ttrd
                               WHERE ttrd.tax_rule_id = :trid AND ttrd.product_tax_class_id = tpt.id AND tpt.id = tptt.owner_id AND tptt.language = :lang";
        $connection    = UsniAdaptor::app()->getDb();
        $records       = $connection->createCommand($sql, [':trid' => $this->id, ':lang' => $language])->queryAll();
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
    
    /**
     * Get product attributes.
     * @return \yii\db\ActiveQuery
     */
    public function getTaxRuleDetails()
    {
       return $this->hasMany(TaxRuleDetails::className(), ['tax_rule_id' => 'id']);
    }
    
    /**
     * Gets customer group.
     * @param $data TaxRule
     * @return string
     */
    public function getCustomerGroup($data)
    {
       $groupTable            = UsniAdaptor::tablePrefix() . 'group';
       $trGroupTable          = UsniAdaptor::tablePrefix() . 'group_translated';
       $taxRuleDetailsTable   = UsniAdaptor::tablePrefix() . 'tax_rule_details';
       $language       = UsniAdaptor::app()->languageManager->getContentLanguage();
       $sql            = "SELECT DISTINCT tgt.name
                               FROM $groupTable tg,  $trGroupTable tgt, $taxRuleDetailsTable ttrd
                               WHERE ttrd.tax_rule_id = :trid AND ttrd.customer_group_id = tg.id AND tg.id = tgt.owner_id AND tgt.language = :lang";
        $connection    = UsniAdaptor::app()->getDb();
        $records       = $connection->createCommand($sql, [':trid' => $data->id, ':lang' => $language])->queryAll();
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
     * Render tax rates.
     * @return string
     */
    public function renderTaxRates()
    {
       $taxRateTable            = UsniAdaptor::tablePrefix() . 'tax_rate';
       $trTaxRateTable          = UsniAdaptor::tablePrefix() . 'tax_rate_translated';
       $taxRuleDetailsTable     = UsniAdaptor::tablePrefix() . 'tax_rule_details';
       $language       = UsniAdaptor::app()->languageManager->getContentLanguage();
       $sql            = "SELECT DISTINCT ttrt.name
                               FROM $taxRateTable ttr,  $trTaxRateTable ttrt, $taxRuleDetailsTable ttrd
                               WHERE ttrd.tax_rule_id = :trid AND ttrd.tax_rate_id = ttr.id AND ttr.id = ttrt.owner_id AND ttrt.language = :lang";
        $connection    = UsniAdaptor::app()->getDb();
        $records       = $connection->createCommand($sql, [':trid' => $this->id, ':lang' => $language])->queryAll();
        if(!empty($records))
        {
            $taxRateNames  = [];
            foreach ($records as $record)
            {
                $taxRateNames[] = $record['name'];
            }
            return implode(', ', $taxRateNames);
        }
        return UsniAdaptor::t('application', '(not set)');
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