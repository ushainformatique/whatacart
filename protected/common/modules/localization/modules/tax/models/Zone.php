<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace taxes\models;

use usni\library\components\TranslatableActiveRecord;
use usni\UsniAdaptor;
use common\modules\localization\modules\country\models\Country;
use common\modules\localization\modules\state\models\State;
use common\modules\localization\modules\country\models\CountryTranslated;
use common\modules\localization\modules\state\models\StateTranslated;
use taxes\utils\TaxUtil;
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
        $zone = TaxUtil::getZoneBasedOnNameCountryStateZipAndLanguage($this);
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
     * Gets zone country.
     * @param $data Zone
     * @return string
     */
    public function getZoneCountry($data)
    {
        $language       = UsniAdaptor::app()->languageManager->getContentLanguage();
        if($data->country_id == '-1')
        {
            return UsniAdaptor::t('localization', 'All Countries');
        }
        $country = CountryTranslated::find()->where('owner_id = :id AND language = :lang', [':id' => $data->country_id, ':lang' => $language])->asArray()->one();
        return $country['name'];
    }
    
    /**
     * Gets zone state.
     * @param $data Zone
     * @return string
     */
    public function getZoneState($data)
    {
        $language       = UsniAdaptor::app()->languageManager->getContentLanguage();
        if($data->state_id == '-1')
        {
            return UsniAdaptor::t('localization', 'All States');
        }
        $state = StateTranslated::find()->where('owner_id = :id AND language = :lang', [':id' => $data->state_id, ':lang' => $language])->asArray()->one();
        return $state['name'];
    }
    
    /**
     * @inheritdoc
     */
    public function beforeDelete()
    {
        if(parent::beforeDelete())
        {
            return TaxUtil::checkIfZoneAllowedToDelete($this);
        }
        return false;
    }
}