<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\localization\modules\state\models;

use usni\library\components\TranslatableActiveRecord;
use usni\UsniAdaptor;
use common\modules\localization\modules\country\models\Country;
use common\modules\localization\modules\state\utils\StateUtil;
/**
 * State active record.
 * @package common\modules\localization\modules\state\models
 */
class State extends TranslatableActiveRecord
{
	/**
     * @inheritdoc
     */
	public function rules()
	{
        return [
                    ['name',                    'required'],
                    ['name',                    'validateName'],
                    ['country_id',              'required'],
                    ['country_id',              'integer'],
                    ['code',                    'string'],
                    ['name',                    'string', 'max' => 32],
                    [['id', 'name', 'code', 'country_id', 'status'], 'safe'],
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
        $state  = StateUtil::getStateBasedOnNameLanguageAndCountry($this);
        if (!empty($state))
        {
            if(($this->scenario == 'create') || ($this->scenario == 'update' && $this->id != $state['id']))
            {
                $countryName = $state['country_name'];
                $this->addError($attribute, UsniAdaptor::t('localization', "The combination $this->name - $this->language - $countryName of Name, Language and Country has already been taken."));
            }
        }
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        $scenario = parent::scenarios();
        $scenario['create'] = $scenario['update'] = ['name', 'code', 'country_id', 'status'];
        $scenario['bulkedit']   = ['status'];
        return $scenario;
    }

	/**
     * @inheritdoc
     */
	public function attributeLabels()
	{
		$labels = [
			'id'            => UsniAdaptor::t('application', 'Id'),
			'country_id'	=> UsniAdaptor::t('country', 'Country'),
			'name'			=> UsniAdaptor::t('application', 'Name'),
			'code'			=> UsniAdaptor::t('localization', 'Code'),
			'status'		=> UsniAdaptor::t('application', 'Status'),
		];
        return parent::getTranslatedAttributeLabels($labels);
	}

	/**
     * @inheritdoc
     */
    public static function getLabel($n = 1)
    {
        return ($n == 1) ? UsniAdaptor::t('state', 'State') : UsniAdaptor::t('state', 'States');
    }

    /**
     * Get country using a relation.
     * @return ActiveQuery
     */
    public function getCountry()
    {
        return $this->hasOne(Country::className(), ['id' => 'country_id']);
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
            return StateUtil::checkIfStateAllowedToDelete($this);
        }
        return false;
    }
}