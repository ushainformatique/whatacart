<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace products\models;

use usni\library\db\ActiveRecord;
use products\models\ProductAttribute;
/**
 * ProductAttributeMapping active record.
 * 
 * @package products\models
 */
class ProductAttributeMapping extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
                    [['product_id', 'attribute_id', 'attribute_value'],  'required'],
                    [['product_id', 'attribute_id', 'attribute_value'],  'safe']
               ];
    }
    
    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        $scenario               = parent::scenarios();
        $scenario['create']     = $scenario['update'] = ['product_id', 'attribute_id', 'attribute_value'];
        return $scenario;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'attribute_id' => 'Name',
            'attribute_value' => 'Value',
            'product_id' => 'Product',
        ];
    }

    /**
     * @inheritdoc
     */
    public static function getLabel($n = 1)
    {
        return UsniAdaptor::t('application', 'Manage') . ' ' . ProductAttribute::getLabel(2);
    }

    /**
     * @inheritdoc
     */
    public function attributeHints()
    {
        return [];
    }
    
    /**
     * Get product attribute mapping
     * @param int $productId
     * @param int $attributeId
     * @return array
     */
    public static function getMapping($productId, $attributeId)
    {
        return ProductAttributeMapping::find()->where('product_id = :pid AND attribute_id = :aid', [':pid' => $productId, ':aid' => $attributeId])->one();
    }
}