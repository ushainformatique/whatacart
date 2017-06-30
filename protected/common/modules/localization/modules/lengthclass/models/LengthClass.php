<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\localization\modules\lengthclass\models;

use usni\library\db\TranslatableActiveRecord;
use usni\UsniAdaptor;
use products\dao\ProductDAO;
use yii\db\Exception;
/**
 * LengthClass class file
 * 
 * @package common\modules\localization\modules\lengthclass\models
 */
class LengthClass extends TranslatableActiveRecord
{
	/**
     * @inheritdoc
     */
	public function rules()
	{
		return [
                    [['name', 'value', 'unit'], 'required'],
                    ['name',                    'unique', 'targetClass' => LengthClassTranslated::className(), 'targetAttribute' => ['name', 'language'], 'on' => 'create'],
                    ['name',                    'unique', 'targetClass' => LengthClassTranslated::className(), 'targetAttribute' => ['name', 'language'], 'filter' => ['!=', 'owner_id', $this->id], 'on' => 'update'],
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
        return ($n == 1) ? UsniAdaptor::t('lengthclass', 'Length Class') : UsniAdaptor::t('lengthclass', 'Length Classes');
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
        if(!$isAllowedToDelete)
        {
            throw new Exception('this model is associated to product');
        }
        return parent::beforeDelete();
    }
    
    /**
     * Check if allowed to delete.
     * @return boolean
     */
    public function checkIfAllowedToDelete()
    {
        $count = ProductDAO::getCountByAttribute('length_class', $this->id);
        if($this->value != 1.00 && $count == 0)
        {
            return true;
        }
        return false;
    }
}