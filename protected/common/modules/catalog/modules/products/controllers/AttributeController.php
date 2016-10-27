<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace products\controllers;

use products\models\ProductAttribute;
use common\modules\catalog\controllers\BaseController;
use usni\UsniAdaptor;
use products\models\ProductAttributeMapping;
use products\views\AssignProductAttributeEditView;
use products\models\Product;
use usni\library\utils\PermissionUtil;
use yii\web\ForbiddenHttpException;
use products\utils\ProductUtil;
/**
 * AttributeController class file.
 * @package products\controllers
 */
class AttributeController extends BaseController
{
    use \usni\library\traits\EditViewTranslationTrait;
    
    /**
     * @inheritdoc
     */
    protected function resolveModelClassName()
    {
        return ProductAttribute::className();
    }
    
    /**
     * Assign attributes to product
     * @param int $product_id
     * @return string
     */
    public function actionProductAttributes($product_id)
    {
        if(ProductUtil::checkIfProductAllowedToPerformAction($product_id) == false)
        {
            throw new \yii\web\NotFoundHttpException();
        }
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
                                        'label' => UsniAdaptor::t('application', 'Manage') . ' ' . ProductAttribute::getLabel(2)
                                    ]
                             ];
            $this->getView()->params['breadcrumbs']  = $breadcrumbs;
            $model              = new ProductAttributeMapping();
            $model->product_id  = $product_id;
            $assignView         = new AssignProductAttributeEditView(['model' => $model]);
            $content            = $this->renderColumnContent([$assignView]);
            return $this->render($this->getDefaultLayout(), array('content' => $content));
        }
        else
        {
            throw new ForbiddenHttpException(\Yii::t('yii','You are not authorized to perform this action.'));
        }
    }
    
    /**
     * Assign product attribute.
     * @return void
     */
    public function actionAssign()
    {
        $productId                      = $_POST['ProductAttributeMapping']['product_id'];
        $attributeId                    = $_POST['ProductAttributeMapping']['attribute_id'];
        $productAttributeMapping        = ProductAttributeMapping::find()->where('attribute_id = :aid AND product_id = :pid', 
                                                                                            [
                                                                                                ':aid' => $attributeId,
                                                                                                ':pid' => $productId
                                                                                            ])->one();
        if($productAttributeMapping == null)
        {
            $productAttributeMapping = new ProductAttributeMapping();
        }
        $productAttributeMapping->attributes   = $_POST['ProductAttributeMapping'];   
        $productAttributeMapping->save();
        echo '';
    }
    
    /**
     * Modify attribute value
     * @param int $product_id
     * @param int $attribute_id
     * @return string
     */
    public function actionModify($product_id, $attribute_id)
    {
        if(ProductUtil::checkIfProductAllowedToPerformAction($product_id) == false)
        {
            throw new \yii\web\NotFoundHttpException();
        }
        $product       = Product::findOne($product_id);
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
                                    'label' => UsniAdaptor::t('application', 'Manage') . ' ' . ProductAttribute::getLabel(2)
                                ]
                         ];
        $this->getView()->params['breadcrumbs']  = $breadcrumbs;
        $productAttributeMapping    = ProductAttributeMapping::getMapping($product_id, $attribute_id);
        $assignView             = new AssignProductAttributeEditView(['model' => $productAttributeMapping]);
        $content                = $this->renderColumnContent([$assignView]);
        return $this->render($this->getDefaultLayout(), array('content' => $content));
    }
    
    /**
     * Remove attribute value
     * @param int $product_id
     * @param int $attribute_id
     * @return string
     */
    public function actionRemove($product_id, $attribute_id)
    {
        if(ProductUtil::checkIfProductAllowedToPerformAction($product_id) == false)
        {
            throw new \yii\web\NotFoundHttpException();
        }
        $productAttributeMapping    = ProductAttributeMapping::getMapping($product_id, $attribute_id);
        $redirectUrl                = ['/catalog/products/attribute/product-attributes', 'product_id' => $product_id];
        $productAttributeMapping->delete();
        return $this->redirect($redirectUrl);
    }
    
    /**
     * @inheritdoc
     */
    public function pageTitles()
    {
        return [
                    'create'                => UsniAdaptor::t('application','Create') . ' ' . ProductAttribute::getLabel(1),
                    'update'                => UsniAdaptor::t('application','Update') . ' ' . ProductAttribute::getLabel(1),
                    'view'                  => UsniAdaptor::t('application','View') . ' ' . ProductAttribute::getLabel(1),
                    'manage'                => UsniAdaptor::t('application','Manage') . ' ' . ProductAttribute::getLabel(2),
                    'product-attributes'    => UsniAdaptor::t('application','Manage') . ' ' . ProductAttribute::getLabel(2)
               ];
    }
    
    /**
     * @inheritdoc
     */
    protected function getActionToPermissionsMap()
    {
        $permissionsMap                         = parent::getActionToPermissionsMap();
        $permissionsMap['product-attributes']   = 'product.update';
        $permissionsMap['assign']               = 'product.update';
        return $permissionsMap;
    }
}