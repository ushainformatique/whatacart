<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\localization\modules\currency\models;

use usni\library\db\TranslatableActiveRecord;
use usni\UsniAdaptor;
use common\modules\localization\modules\currency\models\CurrencyTranslated;
use yii\db\Exception;
use common\modules\order\dao\OrderDAO;
/**
 * Currency active record.
 * 
 * @package common\modules\localization\modules\currency\models
 */
class Currency extends TranslatableActiveRecord
{
	/**
     * @inheritdoc
     */
	public function rules()
	{
		return [
                    [['name', 'code', 'value'],         'required'],
                    ['name',                            'unique', 'targetClass' => CurrencyTranslated::className(), 'targetAttribute' => ['name', 'language'], 'on' => 'create'],
                    ['name',                            'unique', 'targetClass' => CurrencyTranslated::className(), 'targetAttribute' => ['name', 'language'], 'filter' => ['!=', 'owner_id', $this->id], 'on' => 'update'],
                    ['code',                            'unique', 'on' => 'create'],
                    ['code',                            'unique', 'filter' => ['!=', 'id', $this->id], 'on' => 'update'],
                    ['status',                          'integer'],
                    ['value',                           'number', 'numberPattern' => '/^\s*[-+]?[0-9]*[.,]?[0-9]+([eE][-+]?[0-9]+)?\s*$/'],
                    ['name',                            'string', 'max'=> 64],
                    ['code',                            'string', 'max' => 3],
                    [['symbol_left', 'symbol_right'],   'string', 'max' => 10],
                    ['decimal_place',                   'integer'],
                    [['id', 'name', 'code', 'symbol_left', 'symbol_right', 'decimal_place', 'value', 'status'], 'safe'],
               ];
	}

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        $scenario               = parent::scenarios();
        $scenario['create']     = $scenario['update'] = ['name', 'code', 'status', 'value', 'symbol_left', 'symbol_right', 'decimal_place'];
        $scenario['bulkedit']   = ['status'];
        return $scenario;
    }

    /**
     * @inheritdoc
     */
	public function attributeLabels()
	{
		$labels = [
                        'name'					 => UsniAdaptor::t('application', 'Name'),
                        'code'					 => UsniAdaptor::t('localization', 'Code'),
                        'symbol_left'			 => UsniAdaptor::t('currency', 'Symbol Left'),
                        'symbol_right'			 => UsniAdaptor::t('currency', 'Symbol Right'),
                        'decimal_place'			 => UsniAdaptor::t('currency', 'Decimal Places'),
                        'value'					 => UsniAdaptor::t('application', 'Value'),
                        'status'				 => UsniAdaptor::t('application', 'Status'),
                  ];
        return parent::getTranslatedAttributeLabels($labels);
	}

    /**
     * @inheritdoc
     */
    public static function getLabel($n = 1)
    {
        return ($n == 1) ? UsniAdaptor::t('currency', 'Currency') : UsniAdaptor::t('currency', 'Currencies');
    }
    
    /**
     * @inheritdoc
     */
    public static function getTranslatableAttributes()
    {
        return ['name'];
    }
    
    /**
     * Check if allowed to delete.
     * 
     * @param Currency $model
     * @return boolean
     */
    public function checkIfAllowedToDelete()
    {
        //Check the orders associated
        $orders = OrderDAO::getOrdersByAttribute('currency_code', $this->code, $this->language);
        if(empty($orders))
        {
            return true;
        }
        return false;
    }
    
    /**
     * inheritdoc
     */
    public function beforeDelete()
    {
        $isAllowedToDelete = $this->checkIfAllowedToDelete();
        if($isAllowedToDelete == false)
        {
            throw new Exception('This model is associated to orders in the system.');
        }
        if($this->value == 1.00)
        {
            throw new Exception('This is base currency for the system and can not be deleted.');
        }
        return parent::beforeDelete();
    }
}