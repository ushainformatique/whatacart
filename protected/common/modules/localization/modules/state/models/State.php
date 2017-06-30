<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\localization\modules\state\models;

use usni\library\db\TranslatableActiveRecord;
use usni\UsniAdaptor;
use common\modules\localization\modules\country\models\Country;
use yii\db\Exception;
use common\modules\localization\modules\state\dao\StateDAO;
use taxes\models\Zone;
/**
 * State active record.
 * 
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
                    [['name', 'country_id'],    'required'],
                    ['name',                    'validateName'],
                    ['country_id',              'integer'],
                    ['code',                    'string'],
                    ['name',                    'string', 'max' => 32],
                    [['id', 'name', 'code', 'country_id', 'status'], 'safe'],
               ];
	}
    
    /**
     * Validate Name
     * @param string $attribute
     * @param array  $params
     * @return void
     */
    public function validateName($attribute, $params)
    {
        $state  = StateDAO::getStateBasedOnNameLanguageAndCountry($this->country_id, $this->name, $this->language);
        if ($state !== false)
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
        $isAllowedToDelete = $this->checkIfAllowedToDelete();
        if($isAllowedToDelete == false)
        {
            throw new Exception('this state is associated with Zone.');
        }
        return parent::beforeDelete();
    }
    
    /**
     * Check if state is allowed to delete.
     * @return boolean
     */
    public function checkIfAllowedToDelete()
    {
        $zoneCount = Zone::find()->where('state_id = :sid', [':sid' => $this->id])->count();
        if($zoneCount > 0)
        {
            return false;
        }
        return true;
    }
}