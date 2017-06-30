<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace products\models;

use usni\library\db\TranslatableActiveRecord;
use usni\UsniAdaptor;
use products\models\ProductOptionValue;

/**
 * ProductOption class file.
 * 
 * @package products\models
 */
class ProductOption extends TranslatableActiveRecord
{   
    /**
     * @inheritdoc
     */
	public function rules()
	{
        return [
                    [['name', 'display_name'],                       'required'],
                    ['name',    'unique', 'targetClass' => ProductOptionTranslated::className(), 'targetAttribute' => ['name', 'language'], 'on' => 'create'],
                    ['name',    'unique', 'targetClass' => ProductOptionTranslated::className(), 'targetAttribute' => ['name', 'language'], 'filter' => ['!=', 'owner_id', $this->id], 'on' => 'update'],
                    [['name', 'display_name', 'type'], 'string', 'max' => 128],
                    [['name', 'display_name', 'type'],     'safe'],
               ];
	}
    
    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        $scenario               = parent::scenarios();
        $scenario['update']     = $scenario['create']     = ['name', 'display_name', 'type'];
        return $scenario;
    }
    
	/**
     * @inheritdoc
     */
    public static function getLabel($n = 1)
    {
        return ($n == 1) ? UsniAdaptor::t('products', 'Option') : UsniAdaptor::t('products', 'Options');
    }
    
    /**
     * @inheritdoc
     */
	public function attributeLabels()
	{
		$labels = [
                    'name'              => UsniAdaptor::t('products', 'Option Name'),
                    'display_name'      => UsniAdaptor::t('products', 'Display Name'),
                    'type'              => UsniAdaptor::t('application', 'Type'),
                  ];
        return parent::getTranslatedAttributeLabels($labels);
	}
    
    /**
     * @inheritdoc
     */
    public static function getTranslatableAttributes()
    {
        return ['display_name', 'name'];
    }
    
    /**
     * Gets option values.
     * @return ActiveQuery
     */
    public function getOptionValues()
    {
        return $this->hasMany(ProductOptionValue::className(), ['option_id' => 'id']);
    }
    
    /**
     * @inheritdoc
     */
    public function beforeDelete()
    {
        if (parent::beforeDelete())
        {
            $optionValues = $this->optionValues;
            foreach($optionValues as $optionValue)
            {
                $optionValue->delete();
            }
            return true;
        }
        else
        {
            return false;
        }
    }
}