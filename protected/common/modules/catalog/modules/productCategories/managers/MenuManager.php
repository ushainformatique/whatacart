<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace productCategories\managers;

use productCategories\models\ProductCategory;

/**
 * MenuManager class file.
 * 
 * @package common\modules\catalog\components
 */
class MenuManager extends \usni\library\managers\BaseMenuManager
{
    /**
     * @inheritdoc
     */
    public static function getModelClassName()
    {
        return ProductCategory::className();
    }
    
    /**
     * @inheritdoc
     */
    public static function getIcon()
    {
        return null;
    }
    
    /**
     * @inheritdoc
     */
    public static function getModuleUniqueId()
    {
        return 'catalog/productCategories';
    }
}
