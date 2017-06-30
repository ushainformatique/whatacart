<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace products\models;

use usni\library\db\ActiveRecord;
use usni\UsniAdaptor;
/**
 * ProductOptionMapping active record.
 * @package products\models
 */
class ProductOptionMappingDetails extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
                    [['mapping_id', 'option_value_id', 'quantity', 'subtract_stock', 'price_prefix', 'weight_prefix'],  'required'],
                    [['price', 'weight'], 'default', 'value' => 0.00],
                    [['quantity'], 'number', 'integerOnly' => true],
                    [['mapping_id', 'option_value_id', 'quantity', 'subtract_stock', 'price', 'weight', 'price_prefix', 'weight_prefix'],  'safe']
               ];
    }
    
    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        $scenario               = parent::scenarios();
        $scenario['create']     = $scenario['update'] = ['mapping_id', 'option_value_id', 'quantity', 'subtract_stock', 'price', 'weight', 'price_prefix', 'weight_prefix'];
        return $scenario;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'mapping_id'        => UsniAdaptor::t('products', 'Mapping Id'),
            'quantity'          => UsniAdaptor::t('products', 'Quantity'),
            'subtract_stock'    => UsniAdaptor::t('products', 'Subtract stock'),
            'price'             => UsniAdaptor::t('products', 'Price'),
            'weight'            => UsniAdaptor::t('products', 'Weight'),
            'price_prefix'      => UsniAdaptor::t('products', 'Price Prefix'),
            'weight_prefix'     => UsniAdaptor::t('products', 'Weight Prefix')
        ];
    }

    /**
     * @inheritdoc
     */
    public static function getLabel($n = 1)
    {
        return null;
    }

    /**
     * @inheritdoc
     */
    public function attributeHints()
    {
        return [];
    }
    
    /**
     * Get product options mapping 
     * @return ActiveQuery
     */
    public function getOptionMapping()
    {
        return $this->hasOne(ProductOptionMapping::className(), ['id' => 'mapping_id']);
    }
}
?>