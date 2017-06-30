<?php

/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\stores\models;

use usni\UsniAdaptor;
/**
 * StoreLocal active record.
 * 
 * @package common\modules\stores\models
 */
class StoreLocal extends \yii\base\Model
{
    public $country;
    public $timezone;
    public $state;
    public $currency;
    public $length_class;
    public $weight_class;
    public $language;
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
                    [['country', 'timezone', 'state', 'currency', 'length_class', 'weight_class', 'language'], 'required'],
                    ['length_class', 'integer'],
                    ['weight_class', 'integer'],
                    [['country', 'timezone', 'state', 'currency', 'length_class', 'weight_class', 'language'], 'safe'],
               ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        $scenario = parent::scenarios();
        $scenario['create'] = $scenario['update'] = ['country', 'timezone', 'state', 'currency', 'length_class', 'weight_class', 'language'];
        return $scenario;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
                        'id'            => UsniAdaptor::t('application', 'Id'),
                        'country'       => UsniAdaptor::t('country', 'Country'),
                        'state'         => UsniAdaptor::t('state', 'State'),
                        'timezone'      => UsniAdaptor::t('users', 'Timezone'),
                        'weight_class'  => UsniAdaptor::t('weightclass', 'Weight Class'),
                        'length_class'  => UsniAdaptor::t('lengthclass', 'Length Class'),
                        'currency'      => UsniAdaptor::t('currency', 'Currency'),
                        'language'      => UsniAdaptor::t('application', 'Language'),
                  ];
    }

    /**
     * @inheritdoc
     */
    public function attributeHints()
    {
        $hints = [
                    'country'       => UsniAdaptor::t('storehint', 'Country for the store'),
                    'state'         => UsniAdaptor::t('storehint', 'State for the store'),
                    'timezone'      => UsniAdaptor::t('storehint', 'Timezone in which store operates'),
                    'weight_class'  => UsniAdaptor::t('storehint', 'Weight Class for the store'),
                    'length_class'  => UsniAdaptor::t('storehint', 'Length Class for the store'),
                    'currency'      => UsniAdaptor::t('storehint', 'Change the default currency. Clear your browser cache to see the change and reset your existing cookie.'),
                    'language'      => UsniAdaptor::t('storehint', 'Language for the store')
                 ];
        return $hints;
    }

    /**
     * @inheritdoc
     */
    public static function getLabel($n = 1)
    {
        return UsniAdaptor::t('stores', 'Local');
    }
}