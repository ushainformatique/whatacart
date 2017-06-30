<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace taxes\models;

use usni\library\db\TranslatableActiveRecord;
use usni\UsniAdaptor;
use common\modules\localization\modules\country\models\Country;
use common\modules\localization\modules\state\models\State;
use taxes\dao\TaxRuleDAO;
use yii\db\Exception;
use taxes\dao\ZoneDAO;
/**
 * Zone active record.
 * 
 * @package taxes\models
 */
class Zone extends TranslatableActiveRecord 
{   
	/**
     * @inheritdoc
     */
	public function rules()
	{
		return [
                    [['name', 'country_id', 'state_id'],                   'required'],
                    ['name',                                               'validateName'],
                    ['description',                                        'safe'],
                    [['country_id', 'state_id'],                           'number'],
                    ['name',                                               'string', 'max'=>64],
                    ['zip',                                                'default', 'value' => '*'],
                    [['id', 'name', 'country_id', 'state_id', 'description', 'zip', 'is_zip_range', 'from_zip', 'to_zip'],   'safe'],
                    ['from_zip', 'required', 
                    'whenClient' => "function(attribute, value){
                        return $('#zone-is_zip_range').val() == '1';
                     }", 
                    'when' => [$this, 'validateZipRange']
                    ],
                    ['to_zip', 'required', 
                    'whenClient' => "function(attribute, value){
                        return $('#zone-is_zip_range').val() == '1';
                     }", 
                    'when' => [$this, 'validateZipRange']
                    ]
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
        $zone = $this->getZoneBasedOnNameCountryStateZipAndLanguage();
        if (!empty($zone))
        {
            if(($this->scenario == 'create') || ($this->scenario == 'update' && $this->id != $zone['id']))
            {
                $countryName    = $zone['country_name'];
                $stateName      = $zone['state_name'];
                $this->addError($attribute, UsniAdaptor::t('tax', "The combination $this->name - $countryName - $stateName - $this->zip - $this->language of Name, Country, State, Zip and Language has already been taken."));
            }
        }
    }
    
    /**
     * Get zone based on name, country, state, zip and language.
     * @return array
     */
    public function getZoneBasedOnNameCountryStateZipAndLanguage()
    {
        if($this->is_zip_range == true)
        {
            return ZoneDAO::getZoneWithZipRange($this);
        }
        return ZoneDAO::getZoneWithZip($this);
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        $scenario               = parent::scenarios();
        $scenario['create']     = $scenario['update'] = ['name', 'country_id', 'state_id', 'description', 'zip', 'is_zip_range', 'from_zip', 'to_zip'];
        $scenario['bulkedit']   = ['country_id', 'state_id'];
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
                        'country_id'			 => UsniAdaptor::t('country', 'Country'),
                        'state_id'				 => UsniAdaptor::t('state', 'State'),
                        'description'            => UsniAdaptor::t('application', 'Description'),
                        'zip'                    => UsniAdaptor::t('tax', 'Zip'),
                        'is_zip_range'           => UsniAdaptor::t('tax', 'Is Zip Range'),
                        'from_zip'               => UsniAdaptor::t('tax', 'From zip'),
                        'to_zip'                 => UsniAdaptor::t('tax', 'To zip'),
                  ];
        return parent::getTranslatedAttributeLabels($labels);
	}

    /**
     * @inheritdoc
     */
    public static function getLabel($n = 1)
    {
        return ($n == 1) ? UsniAdaptor::t('tax', 'Zone') : UsniAdaptor::t('tax', 'Zones');
    }
    
    /**
     * Get country for the zone.
     * @return ActiveQuery
     */
    public function getCountry()
    {
        return $this->hasOne(Country::className(), ['id' => 'country_id']);
    }
    
    /**
     * Get state for the zone.
     * @return ActiveQuery
     */
    public function getState()
    {
        return $this->hasOne(State::className(), ['id' => 'state_id']);
    }
    
    /**
     * @inheritdoc
     */
    public static function getTranslatableAttributes()
    {
        return ['name', 'description'];
    }
    
    /**
     * Validate the zip range based on selection
     * @param string $attribute Attribute having user attribute related to login.
     * @param array  $params
     * @return void
     */
    public function validateZipRange($attribute, $params)
    {
        if (!$this->hasErrors())
        {
            if((bool)$this->is_zip_range == true)
            {
                if($this->from_zip == null)
                {
                    $this->addError('from_zip', UsniAdaptor::t('tax', 'From zip is required.'));
                }
                if($this->to_zip == null)
                {
                    $this->addError('to_zip', UsniAdaptor::t('tax', 'To zip is required.'));
                }
                if($this->from_zip > $this->to_zip)
                {
                    $this->addError('from_zip', UsniAdaptor::t('tax', 'From zip should be less than to zip.'));
                }
            }            
        }
    }
    
    /**
     * @inheritdoc
     */
    public function beforeDelete()
    {
        $isAllowedToDelete = $this->checkIfAllowedToDelete();
        if(!$isAllowedToDelete)
        {
            throw new Exception('this zone is associated with tax rule.');
        }
        return parent::beforeDelete();
    }
    
    /**
     * Check if zone is allowed to delete.
     * @return boolean
     */
    public function checkIfAllowedToDelete()
    {
        $taxRule    = TaxRuleDAO::getTaxRuleByAttribute('tax_zone_id', $this->id, $this->language);
        if(empty($taxRule))
        {
            return true;
        }
        return false;
    }
}