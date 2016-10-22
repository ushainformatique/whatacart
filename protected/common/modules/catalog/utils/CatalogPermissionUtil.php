<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace common\modules\catalog\utils;

use usni\library\utils\PermissionUtil;
use productCategories\models\ProductCategory;
use products\models\Product;
use products\models\ProductAttributeGroup;
use products\models\ProductAttribute;
use products\models\ProductOption;
use products\models\ProductReview;
use usni\UsniAdaptor;
/**
 * CatalogPermissionUtil class file.
 *
 * @package common\modules\catalog\utils
 */
class CatalogPermissionUtil extends PermissionUtil
{

    /**
     * Gets models associated to the catalog module.
     * @return array
     */
    public static function getModels()
    {
        return [
                    ProductCategory::className(),
                    Product::className(),
                    ProductAttributeGroup::className(),
                    ProductAttribute::className(),
                    ProductOption::className(),
                    ProductReview::className(),
               ];
    }

    /**
     * @inheritdoc
     */
    public static function getModuleId()
    {
        return 'catalog';
    }
    
    /**
     * @inheritdoc
     */
    public static function getPermissions()
    {
        $permissions = parent::getPermissions();
        unset($permissions['ProductReview']['productreview.create']);
        unset($permissions['ProductReview']['productreview.view']);
        unset($permissions['ProductReview']['productreview.viewother']);
        unset($permissions['ProductReview']['productreview.update']);
        unset($permissions['ProductReview']['productreview.updateother']);
        unset($permissions['ProductReview']['productreview.bulk-edit']);
        unset($permissions['ProductReview']['productreview.create']);
        $permissions['ProductReview']['productreview.bulk-approve'] = UsniAdaptor::t('products', 'Bulk Approve');
        $permissions['ProductReview']['productreview.approve'] = UsniAdaptor::t('products', 'Approve');
        $permissions['ProductReview']['productreview.approveother'] = UsniAdaptor::t('products', 'Approve other reviews');
        $permissions['ProductReview']['productreview.spam'] = UsniAdaptor::t('products', 'Spam');
        $permissions['ProductReview']['productreview.spamother'] = UsniAdaptor::t('products', 'Spam other reviews');
        return $permissions;
    }
}
?>