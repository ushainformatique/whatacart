<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace products\db;

use usni\library\db\DataManager;
use products\models\ProductAttributeGroup;
use usni\UsniAdaptor;
/**
 * Loads default data related to product attribute group.
 * 
 * @package products\db
 */
class ProductAttributeGroupDataManager extends DataManager
{   
    /**
     * @inheritdoc
     */
    public static function getModelClassName()
    {
        return ProductAttributeGroup::className();
    }

    /**
     * @inheritdoc
     */
    public function getDefaultDataSet()
    {
        return [
                    [
                        'name'          => UsniAdaptor::t('products', 'Memory'),
                        'sort_order'    => 1, 
                    ],
                    [
                        'name'          => UsniAdaptor::t('products', 'Motherboard'),
                        'sort_order'    => 2, 
                    ],
                ];
    }
}