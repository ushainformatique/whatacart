<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\catalog;

use usni\library\components\SecuredModule;
use usni\UsniAdaptor;
use productCategories\models\ProductCategory;
use products\models\Product;
use products\models\ProductReview;
/**
 * Provides functionality related to entities specific to the catalog.
 *
 * @package common\modules\catalog
 */
class Module extends SecuredModule
{
    /**
     * Overrides to register translations.
     */
    public function init()
    {
        parent::init();
        $this->registerTranslations();
    }

    /**
     * Registers translations.
     */
    public function registerTranslations()
    {
        UsniAdaptor::app()->i18n->translations['catalog*'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'sourceLanguage' => 'en-US',
            'basePath' => '@approot/messages'
        ];
    }
    
    /**
     * inheritdoc
     */
    public function getPermissionModels()
    {
        return [
                    ProductCategory::className(),
                    Product::className(),
                    ProductReview::className()
               ];
    }
    
    /**
     * @inheritdoc
     */
    public function getPermissions()
    {
        $permissions = parent::getPermissions();
        $permissions['ProductReview']['productreview.approve'] = UsniAdaptor::t('products', 'Approve');
        $permissions['ProductReview']['productreview.spam'] = UsniAdaptor::t('products', 'Spam');
        return $permissions;
    }
    
    /**
     * @inheritdoc
     */
    public function getModelToExcludedPermissions()
    {
         return [ProductReview::className() => ['create', 'update', 'view', 'bulk-edit', 'bulk-delete', 'updateother', 'viewother', 'deleteother']];
    }
}