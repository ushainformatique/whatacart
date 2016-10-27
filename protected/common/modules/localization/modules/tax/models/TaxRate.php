<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace taxes\models;

use usni\library\components\TranslatableActiveRecord;
use usni\UsniAdaptor;
use taxes\models\TaxRule;
use taxes\utils\TaxUtil;
/**
 * TaxRate active record.
 * @package taxes\models
 */
class TaxRate extends TranslatableActiveRecord
{
	/**
     * @inheritdoc
     */
	public function rules()
	{
		return [
                    [['name', 'type', 'value', 'tax_zone_id'],      'required', 'except' => 'bulkedit'],
                    ['name', 'validateName'],
                    [['name', 'type'],                              'string', 'max'=>64],
                    ['value',                                       'number'],
                    ['type', 'default', 'value' => TaxRule::TAX_BASED_ON_SHIPPING],
                    [['id', 'name', 'type'],                        'safe'],
               ];
	}
    
    /**
     * validate Name
     * @param string $attribute Attribute having user attribute related to login.
     * @param array  $params
     * @return void
     */
    public function validateName($attribute, $params)
    {
        $taxrate = TaxUtil::getTaxRateBasedOnZoneAndLanguage($this);
        if (!empty($taxrate))
        {
            if(($this->scenario == 'create') || ($this->scenario == 'update' && $this->id != $taxrate['id']))
            {
                $zoneName = $taxrate['zone_name'];
                $this->addError($attribute, UsniAdaptor::t('tax', "The combination $this->name - $this->language - $zoneName of Name, Language and Zone has already been taken."));
            }
        }
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        $scenario               = parent::scenarios();
        $scenario['create']     = $scenario['update'] = ['name', 'type', 'value', 'tax_zone_id'];
        $scenario['bulkedit']   = ['tax_zone_id'];
        return $scenario;
    }
    
    /**
     * @inheritdoc
     */
	public function attributeLabels()
	{
		$labels = [
                    'id'					 => UsniAdaptor::t('application', 'Id'),
                    'name'					 => UsniAdaptor::t('application', 'Name'),
                    'type'					 => UsniAdaptor::t('application', 'Type'),
                    'value'                  => UsniAdaptor::t('application', 'Value'),
                    'tax_zone_id'            => UsniAdaptor::t('tax', 'Tax Zone')
                  ];
        return parent::getTranslatedAttributeLabels($labels);
	}
    
    /**
     * @inheritdoc
     */
    public static function getLabel($n = 1)
    {
        return ($n == 1) ? UsniAdaptor::t('tax', 'Tax Rate') : UsniAdaptor::t('tax', 'Tax Rates');
    }
    
    /**
     * Gets type display label.
     * @param mixed $data the data model
     * @param mixed $key the key associated with the data model
     * @param integer $index the zero-based index of the data model among the models array returned by [[GridView::dataProvider]].
     * @param DataColumn $column
     * @return string
     */
    public static function getTaxZone($data, $key, $index, $column)
    {
       $taxZone   = Zone::find()->where('id = :id', [':id' => $data->tax_zone_id])->one();
       if(!empty($taxZone))
       {
            return $taxZone->name;
       }
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
    public function beforeDelete()
    {
        if(parent::beforeDelete())
        {
            return TaxUtil::checkIfTaxRateAllowedToDelete($this);
        }
        return false;
    }
}