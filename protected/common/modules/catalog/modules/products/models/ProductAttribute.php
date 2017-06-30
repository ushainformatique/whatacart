<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace products\models;

use usni\library\db\TranslatableActiveRecord;
use usni\UsniAdaptor;
/**
 * ProductAttribute class file.
 * 
 * @package products\models
 */
class ProductAttribute extends TranslatableActiveRecord
{
    /**
     * @inheritdoc
     */
	public function rules()
	{
        return [
                    ['name',            'required'],
                    ['name',            'validateName'],
                    ['name',            'string', 'max' => 128],
                    ['sort_order',      'number', 'integerOnly' => true],
                    [['sort_order', 'attribute_group'],     'safe'],
               ];
	}
    
    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        $scenario               = parent::scenarios();
        $scenario['update']     = $scenario['create']     = ['name', 'sort_order', 'attribute_group'];
        $scenario['bulkedit']   = ['attribute_group'];
        return $scenario;
    }
    
	/**
     * @inheritdoc
     */
    public static function getLabel($n = 1)
    {
        return ($n == 1) ? UsniAdaptor::t('products', 'Attribute') : UsniAdaptor::t('products', 'Attributes');
    }
    
    /**
     * @inheritdoc
     */
	public function attributeLabels()
	{
		$labels = [
                    'name'              => UsniAdaptor::t('products', 'Attribute Name'),
                    'sort_order'        => UsniAdaptor::t('application', 'Sort Order'),
                    'attribute_group'   => UsniAdaptor::t('products', 'Attribute Group')
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
    
    /**
     * Get attribute group.
     * @return \ActiveQuery
     */
    public function getGroup()
    {
        return $this->hasOne(ProductAttributeGroup::className(), ['id' => 'attribute_group']);
    }
    
    /**
     * Validate name in rules
     * @param string $attribute Attribute
     * @param array  $params
     * @return void
     */
    public function validateName($attribute, $params)
    {
        if (!$this->hasErrors())
        {
            $language       = $this->language;
            $tableName      = UsniAdaptor::tablePrefix(). 'product_attribute';
            $trTableName    = UsniAdaptor::tablePrefix(). 'product_attribute_translated';
            if($this->attribute_group == null)
            {
                $sql            = "SELECT pa.* FROM $tableName pa, $trTableName pat WHERE pat.name = :name AND pat.owner_id = pa.id AND pat.language = :lan";
                $record         = UsniAdaptor::app()->db->createCommand($sql, [':name' => $this->name, ':lan' => $language])->queryOne();
            }
            else
            {
                $sql            = "SELECT pa.* FROM $tableName pa, $trTableName pat WHERE pa.attribute_group = :ag AND pa.id = pat.owner_id AND pat.name = :name AND pat.language = :lan";
                $record         = UsniAdaptor::app()->db->createCommand($sql, [':name' => $this->name, ':lan' => $language, ':ag' => $this->attribute_group])->queryOne();
            }
            if ($record !== false && ($this->scenario == 'create' || ($this->scenario == 'update' && $record['id'] != $this->id)))
            {
                if($this->attribute_group == null)
                {
                    $this->addError($attribute, UsniAdaptor::t('products', 'The combination "' . $this->name . '"-"' . $language . '" of Name and Language has already been taken.'));
                }
                else
                {
                    $this->addError($attribute, UsniAdaptor::t('products', 'The combination "' . $this->name . '"-"' . $language . '" of Name and Language has already been taken with the associated group.'));
                }
            }
        }
    }
}