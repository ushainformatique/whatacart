<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace products\models;

use usni\library\db\TranslatableActiveRecord;
use usni\UsniAdaptor;
/**
 * ProductAttributeGroup class file.
 * 
 * @package products\models
 */
class ProductAttributeGroup extends TranslatableActiveRecord
{
    /**
     * @inheritdoc
     */
	public function rules()
	{
        return [
                    ['name',            'required'],
                    ['name',            'unique', 'targetClass' => ProductAttributeGroupTranslated::className(), 'targetAttribute' => ['name', 'language'], 'on' => 'create'],
                    ['name',            'unique', 'targetClass' => ProductAttributeGroupTranslated::className(), 'targetAttribute' => ['name', 'language'], 'filter' => ['!=', 'owner_id', $this->id], 'on' => 'update'],
                    ['name',            'string', 'max' => 128],
                    ['sort_order',      'safe'],
               ];
	}
    
    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        $scenario               = parent::scenarios();
        $scenario['update']     = $scenario['create']     = ['name', 'sort_order'];
        return $scenario;
    }
    
	/**
     * @inheritdoc
     */
    public static function getLabel($n = 1)
    {
        return ($n == 1) ? UsniAdaptor::t('products', 'Attribute Group') : UsniAdaptor::t('products', 'Attribute Groups');
    }
    
    /**
     * @inheritdoc
     */
	public function attributeLabels()
	{
		$labels = [
                    'name'          => UsniAdaptor::t('products', 'Attribute Group Name'),
                    'sort_order'    => UsniAdaptor::t('application', 'Sort Order')
                  ];
        return parent::getTranslatedAttributeLabels($labels);
	}
    
    /**
     * @inheritdoc
     */
    public static function getTranslatableAttributes()
    {
        return ['name'];
    }
}