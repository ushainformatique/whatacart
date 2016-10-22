<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace products\managers;

use usni\library\components\UiDataManager;
use products\models\ProductAttribute;
use products\models\ProductAttributeGroupTranslated;
/**
 * Loads default data related to product attribute.
 * 
 * @package products\managers
 */
class ProductAttributeDataManager extends UiDataManager
{   
    /**
     * @inheritdoc
     */
    public static function getModelClassName()
    {
        return ProductAttribute::className();
    }

    /**
     * @inheritdoc
     */
    public static function getDefaultDataSet()
    {
        $attributeGroup   = ProductAttributeGroupTranslated::find()->where('name = :name AND language = :ln', 
                                                                          [':name' => 'Memory', ':ln' => static::getDefaultLanguage()])->one();
        return [
                    [
                        'name'              => 'Clockspeed',
                        'attribute_group'   => $attributeGroup->owner_id,
                        'sort_order'        => 1, 
                    ],
                    [
                        'name'              => 'Fan Speed',
                        'attribute_group'   => $attributeGroup->owner_id,
                        'sort_order'        => 1, 
                    ],
                ];
    }
    
    /**
     * @inheritdoc
     */
    public static function getDefaultDemoDataSet()
    {
        return [];
    }
}