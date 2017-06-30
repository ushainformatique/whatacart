<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\localization\modules\city\models;

use usni\library\db\TranslatableActiveRecord;
use usni\UsniAdaptor;
use common\modules\localization\modules\country\models\Country;
/**
 * City active record.
 * 
 * @package common\modules\localization\modules\city\models
 */
class City extends TranslatableActiveRecord
{
	/**
     * @inheritdoc
     */
	public function rules()
	{
		return [
                    [['name', 'country_id'],    'required'],
                    ['name',                    'unique', 'targetClass' => CityTranslated::className(), 'targetAttribute' => ['name', 'language'], 'on' => 'create'],
                    ['name', 'unique', 'targetClass' => CityTranslated::className(), 'targetAttribute' => ['name', 'language'], 'filter' => ['!=', 'owner_id', $this->id], 'on' => 'update'],
                    ['country_id',              'integer'],
                    ['name',                    'string', 'max' => 64]
               ];
	}

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        $scenario = parent::scenarios();
        $scenario['create'] = $scenario['update'] = ['name', 'country_id'];
        return $scenario;
    }

    /**
     * @inheritdoc
     */
	public function attributeLabels()
	{
		$labels = [
                     'id'				=> UsniAdaptor::t('application', 'Id'),
                     'name'				=> UsniAdaptor::t('application', 'Name'),
                     'country_id'       => UsniAdaptor::t('country', 'Country'),
                  ];
        return parent::getTranslatedAttributeLabels($labels);
	}

    /**
     * @inheritdoc
     */
    public static function getLabel($n = 1)
    {
        return ($n == 1) ? UsniAdaptor::t('city', 'City') : UsniAdaptor::t('city', 'Cities');
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
}