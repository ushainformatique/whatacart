<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace products\controllers;

use products\models\ProductImage;
use usni\UsniAdaptor;
use common\modules\catalog\controllers\BaseController;
use common\modules\catalog\utils\CatalogPermissionUtil;
/**
 * ProductImageController class file
 * @package products\controllers
 */
class ProductImageController extends BaseController
{
    /**
     * @inheritdoc
     */
    protected function resolveModelClassName()
    {
        return ProductImage::className();
    }
    
    /**
     * Get model title
     * @return string
     */
    protected static function getModelTitle()
    {
        return UsniAdaptor::t('products', 'Product Image');
    }
    
    /**
     * Process delete.
     * @param int $id
     * @param array $config
     * @return void
     */
    protected function processDelete($id, $config = [])
    {
        $user           = UsniAdaptor::app()->user->getUserModel();
        $modelClassName = $this->resolveModelClassName();
        $model          = $this->loadModel($modelClassName, $id);
        $isPermissible  = CatalogPermissionUtil::doesUserHavePermissionToPerformAction($model, $user, 'deleteother');
        if(!$isPermissible)
        {
            throw new \yii\web\ForbiddenHttpException(\Yii::t('yii','You are not authorized to perform this action.'));
        }
        else
        {
            $this->deleteModel($model);
            echo "Success";
        }
    }
}
?>