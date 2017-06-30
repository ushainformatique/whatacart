<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\localization\modules\weightclass\models;

use usni\library\db\TranslatableActiveRecord;
use usni\UsniAdaptor;
use common\modules\localization\modules\weightclass\models\WeightClassTranslated;
use yii\db\Exception;
use products\dao\ProductDAO;;
/**
 * WeightClass active record.
 * 
 * @package common\modules\localization\modules\weightclass\models
 */
class WeightClass extends TranslatableActiveRecord
{
	/**
     * @inheritdoc
     */
	public function rules()
	{
		return [
                    [['name', 'value', 'unit'], 'required'],
                    ['name',                    'unique', 'targetClass' => WeightClassTranslated::className(), 'targetAttribute' => ['name', 'language'], 'on' => 'create'],
                    ['name',                    'unique', 'targetClass' => WeightClassTranslated::className(), 'targetAttribute' => ['name', 'language'], 'filter' => ['!=', 'owner_id', $this->id], 'on' => 'update'],
                    ['unit',                    'unique', 'on' => 'create'],
                    ['unit',                    'unique', 'filter' => ['!=', 'id', $this->id], 'on' => 'update'],
                    ['name',                    'string', 'max' => 64],
                    ['unit',                    'string', 'max' => 10],
                    ['value',                   'number'],
                    [['name', 'value', 'unit'], 'safe'],
               ];
	}

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios['create'] = $scenarios['update'] = ['name', 'value', 'unit'];
        return $scenarios;
    }

	/**
     * @inheritdoc
     */
	public function attributeLabels()
	{
		$labels = [
                        'id'    => UsniAdaptor::t('application', 'Id'),
                        'value'	=> UsniAdaptor::t('application', 'Value'),
                        'name'	=> UsniAdaptor::t('application', 'Name'),
                        'unit'	=> UsniAdaptor::t('localization', 'Unit'),
                    ];
        return parent::getTranslatedAttributeLabels($labels);
	}

	/**
     * @inheritdoc
     */
    public static function getLabel($n = 1)
    {
        return ($n == 1) ? UsniAdaptor::t('weightclass', 'Weight Class') : UsniAdaptor::t('weightclass', 'Weight Classes');
    }
    
    /**
     * Get translatable attributes.
     * @return array
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
            throw new Exception('this model is associated to product');
        }
        return parent::beforeDelete();
    }
    
    /**
     * Check if allowed to delete
     * @return boolean
     */
    public function checkIfAllowedToDelete()
    {
        $count = ProductDAO::getCountByAttribute('weight_class', $this->id);
        if($this->value != 1.00 && $count == 0)
        {
            return true;
        }
        return false;
    }
}