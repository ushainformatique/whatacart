<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\localization\modules\country\models;

use usni\library\db\TranslatableActiveRecord;
use usni\UsniAdaptor;
/**
 * Country active record.
 * 
 * @package common\modules\localization\modules\country\models
 */
class Country extends TranslatableActiveRecord
{
    /**
     * @inheritdoc
     */
	public function rules()
	{
		return [
                    ['name',                                   'required'],
                    ['name',                                   'unique', 'targetClass' => CountryTranslated::className(), 'targetAttribute' => ['name', 'language'], 'on' => 'create'],
                    ['name', 'unique', 'targetClass' => CountryTranslated::className(), 'targetAttribute' => ['name', 'language'], 'filter' => ['!=', 'owner_id', $this->id], 'on' => 'update'],
                    [['postcode_required', 'status'],          'integer'],
                    ['name',                                   'string', 'max' => 64],
                    ['iso_code_2',                             'string', 'max' => 2],
                    ['iso_code_3',                             'string', 'max' => 3],
                    ['address_format',                         'safe'],
                    [['name', 'iso_code_2', 'iso_code_3', 'address_format', 'postcode_required', 'status'], 'safe'],
               ];
	}

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        $scenario               = parent::scenarios();
        $commonAttributes       = ['name', 'postcode_required', 'status', 'iso_code_2', 'iso_code_3', 'address_format'];
        $scenario['create']     = $commonAttributes;
        $scenario['update']     = $commonAttributes;
        $scenario['bulkedit']   = ['status', 'postcode_required'];
        return $scenario;
    }

    /**
     * @inheritdoc
     */
	public function attributeLabels()
	{
		$labels = [
                        'name'                  => UsniAdaptor::t('application', 'Name'),
                        'iso_code_2'            => UsniAdaptor::t('localization','Iso Code(2)'),
                        'iso_code_3'            => UsniAdaptor::t('localization','Iso Code(3)'),
                        'address_format'        => UsniAdaptor::t('localization','Address Format'),
                        'postcode_required' 	=> UsniAdaptor::t('localization','Postcode Required'),
                        'status'                => UsniAdaptor::t('application','Status'),
                  ];
        return parent::getTranslatedAttributeLabels($labels);
	}

    /**
     * @inheritdoc
     */
    public static function getLabel($n = 1)
    {
        return ($n == 1) ? UsniAdaptor::t('country', 'Country') : UsniAdaptor::t('country', 'Countries');
    }
    
    /**
     * @inheritdoc
     */
    public static function getTranslatableAttributes()
    {
        return ['name', 'address_format'];
    }
}