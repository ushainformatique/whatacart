<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace products\controllers;

use common\modules\catalog\controllers\BaseController;
use products\views\ProductOptionEditView;
use products\models\ProductOption;
use usni\UsniAdaptor;
use products\utils\ProductUtil;
use products\models\ProductOptionMapping;
use products\views\AssignProductOptionEditView;
use products\views\AssignProductOptionValuesView;
use products\models\Product;
use products\views\AssignProductOptionsListView;
use usni\library\utils\PermissionUtil;
use yii\web\ForbiddenHttpException;
use usni\library\utils\ArrayUtil;
/**
 * OptionController class file.
 * 
 * @package products\controllers
 */
class OptionController extends BaseController
{
    /**
     * @inheritdoc
     */
    protected function resolveModelClassName()
    {
        return ProductOption::className();
    }
    
    /**
     * @inheritdoc
     */
    public function actionCreate()
    {
        $option             = new ProductOption(['scenario' => 'create']);
        return $this->processInsertOrUpdate($option);
    }
    
    /**
     * @inheritdoc
     */
    public function actionUpdate($id)
    {
        $option = ProductOption::findOne($id);
        $user   = UsniAdaptor::app()->user->getUserModel();
        if(PermissionUtil::doesUserHavePermissionToPerformAction($option, $user, 'productoption.updateother') == false)
        {
            throw new ForbiddenHttpException(\Yii::t('yii','You are not authorized to perform this action.'));
        }
        $option->scenario       = 'update';
        return $this->processInsertOrUpdate($option);
    }
    
    /**
     * Process insert or update
     * @param string $option
     * @return string
     */
    protected function processInsertOrUpdate($option)
    {
        if(ProductUtil::validateAndSaveProductOptionData($_POST, $option))
        {
            return $this->redirect(UsniAdaptor::createUrl('/catalog/products/option/manage'));
        }
        $this->setBreadCrumbs($option);
        $editView           = new ProductOptionEditView($option);
        $content            = $this->renderColumnContent([$editView]);
        return $this->render($this->getDefaultLayout(), array('content' => $content));
    }
    
    /**
     * Assign product options to product
     * @param int $product_id
     * @return string
     */
    public function actionProductOptions($product_id)
    {
        $product    = Product::findOne($product_id);
        $user       = UsniAdaptor::app()->user->getUserModel();
        if(PermissionUtil::doesUserHavePermissionToPerformAction($product, $user, 'product.updateother') == true)
        {
            $breadcrumbs   = [
                                [
                                    'label' => UsniAdaptor::t('application', 'Manage') . ' ' . Product::getLabel(2),
                                    'url'   => UsniAdaptor::createUrl('/catalog/products/default/manage')
                                ],
                                [
                                    'label' => $product->name,
                                    'url'   => UsniAdaptor::createUrl('/catalog/products/default/view', ['id' => $product_id])
                                ],
                                [
                                    'label' => UsniAdaptor::t('application', 'Manage') . ' ' . ProductOption::getLabel(2)
                                ]
                             ];
            $this->getView()->params['breadcrumbs']  = $breadcrumbs;
            $model              = new ProductOptionMapping();
            $model->product_id  = $product_id;
            $assignView         = new AssignProductOptionEditView(['model' => $model]);
            $content            = $this->renderColumnContent([$assignView]);
            return $this->render($this->getDefaultLayout(), array('content' => $content));
        }
        else
        {
            throw new ForbiddenHttpException(\Yii::t('yii','You are not authorized to perform this action.'));
        }
    }
    
    /**
     * Get product values.
     * @param int $productId
     * @param int $optionId
     * @return void
     */
    public function actionGetProductValues($productId, $optionId)
    {
        $productOptionMappings  = ProductUtil::getAssigedProductOptionValues($productId, $optionId);
        $optionValuesView       = new AssignProductOptionValuesView(['optionId' => $optionId, 'optionMappings' => $productOptionMappings]);
        echo $this->getView()->renderAjaxWithClass($optionValuesView);
    }
    
    /**
     * Assign product options.
     * @return void
     */
    public function actionAssign()
    {
        $productId  = $_POST['ProductOptionMapping']['product_id'];
        $optionId   = $_POST['ProductOptionMapping']['option_id'];
        $optionValueIdData = ArrayUtil::getValue($_POST['ProductOptionMapping'], 'option_value_id', []);
        $records    = ProductOptionMapping::find()->where('option_id = :aid AND product_id = :pid', [
                                                                                                    ':aid' => $optionId,
                                                                                                    ':pid' => $productId
                                                                                                ])->all();
        foreach($records as $record)
        {
            $record->delete();
        }
        if(!empty($optionValueIdData))
        {
            ProductUtil::saveOptionMappingDetails($productId, $optionId, $_POST['ProductOptionMapping']);
        }
        $product    = Product::findOne($productId);
        $view       = new AssignProductOptionsListView(['product' => $product, 'shouldRenderActionColumn' => false]);
        echo $view->render();
    }
    
    /**
     * Process delete of option for the product.
     * @param int $mappingId
     * @return void
     */
    public function actionRemove($mappingId)
    {
        $model          = ProductOptionMapping::findOne($mappingId);
        $this->deleteModel($model);
        echo "Success";
    }
    
    /**
     * @inheritdoc
     */
    public function pageTitles()
    {
        return [
                    'create'            => UsniAdaptor::t('application','Create') . ' ' . ProductOption::getLabel(1),
                    'update'            => UsniAdaptor::t('application','Update') . ' ' . ProductOption::getLabel(1),
                    'view'              => UsniAdaptor::t('application','View') . ' ' . ProductOption::getLabel(1),
                    'manage'            => UsniAdaptor::t('application','Manage') . ' ' . ProductOption::getLabel(2),
                    'product-options'   => UsniAdaptor::t('products', 'Product Options')
               ];
    }
    
    /**
     * @inheritdoc
     */
    protected function getActionToPermissionsMap()
    {
        $permissionsMap                         = parent::getActionToPermissionsMap();
        $permissionsMap['product-options']      = 'product.update';
        $permissionsMap['get-product-values']   = 'product.update';
        $permissionsMap['assign']               = 'product.update';
        return $permissionsMap;
    }
}