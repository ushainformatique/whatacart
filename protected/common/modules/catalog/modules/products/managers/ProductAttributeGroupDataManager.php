<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace products\managers;

use usni\library\components\UiDataManager;
use products\models\ProductAttributeGroup;
/**
 * Loads default data related to product attribute group.
 * 
 * @package products\managers
 */
class ProductAttributeGroupDataManager extends UiDataManager
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
    public static function getDefaultDataSet()
    {
        return [
                    [
                        'name'          => 'Memory',
                        'sort_order'    => 1, 
                    ],
                    [
                        'name'          => 'Motherboard',
                        'sort_order'    => 2, 
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
?>