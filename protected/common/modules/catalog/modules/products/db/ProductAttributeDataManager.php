<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace products\db;

use usni\library\db\DataManager;
use products\models\ProductAttribute;
use products\models\ProductAttributeGroupTranslated;
use usni\UsniAdaptor;
/**
 * Loads default data related to product attribute.
 * 
 * @package products\db
 */
class ProductAttributeDataManager extends DataManager
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
    public function getDefaultDataSet()
    {
        $attributeGroup   = ProductAttributeGroupTranslated::find()->where('name = :name AND language = :ln', 
                                                                          [':name' => 'Memory', ':ln' => static::getDefaultLanguage()])->one();
        return [
                    [
                        'name'              => UsniAdaptor::t('products', 'Clockspeed'),
                        'attribute_group'   => $attributeGroup->owner_id,
                        'sort_order'        => 1, 
                    ],
                    [
                        'name'              => UsniAdaptor::t('products', 'Fan Speed'),
                        'attribute_group'   => $attributeGroup->owner_id,
                        'sort_order'        => 1, 
                    ],
                ];
    }
}