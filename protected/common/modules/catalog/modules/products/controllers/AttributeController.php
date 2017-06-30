<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace products\controllers;

use products\models\ProductAttribute;
use usni\UsniAdaptor;
use usni\library\web\actions\CreateAction;
use usni\library\web\actions\UpdateAction;
use products\dto\ProductAttributeFormDTO;
use products\business\ProductAttributeManager;
use yii\filters\AccessControl;
use usni\library\web\actions\IndexAction;
use usni\library\web\actions\DeleteAction;
use usni\library\web\actions\BulkDeleteAction;
use usni\library\web\actions\ViewAction;
use products\business\Manager as ProductBusinessManager;
use yii\base\InvalidParamException;
use yii\web\ForbiddenHttpException;
use products\dto\AssignAttributeDTO;
use products\models\ProductAttributeMapping;
use products\dao\ProductDAO;
/**
 * AttributeController class file.
 * 
 * @package products\controllers
 */
class AttributeController extends \usni\library\web\Controller
{
    /**
     * inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index'],
                        'roles' => ['product.manage'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['view'],
                        'roles' => ['product.view'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['create'],
                        'roles' => ['product.create'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['update', 'assign', 'save-assignment', 'modify'],
                        'roles' => ['product.update'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['delete', 'bulk-delete', 'remove'],
                        'roles' => ['product.delete'],
                    ]
                ],
            ],
        ];
    }
    
    /**
     * inheritdoc
     */
    public function actions()
    {
        $managerConfig = ['class'    => ProductAttributeManager::className()];
        return [
            'create' => ['class' => CreateAction::className(),
                         'modelClass' => ProductAttribute::className(),
                         'updateUrl'  => 'update',
                         'managerConfig' => $managerConfig,
                         'viewFile' => '/productattribute/create',
                         'formDTOClass' => ProductAttributeFormDTO::className()
                        ],
            'update' => ['class' => UpdateAction::className(),
                         'modelClass' => ProductAttribute::className(),
                         'managerConfig' => $managerConfig,
                         'viewFile' => '/productattribute/update',
                         'formDTOClass' => ProductAttributeFormDTO::className()
                        ],
            'index'  => ['class' => IndexAction::className(),
                         'modelClass' => ProductAttribute::className(),
                         'viewFile' => '/productattribute/index',
                        ],
            'view'   => ['class' => ViewAction::className(),
                         'modelClass' => ProductAttribute::className(),
                         'managerConfig' => $managerConfig,
                         'viewFile' => '/productattribute/view'
                        ],
            'delete'   => ['class' => DeleteAction::className(),
                         'modelClass' => ProductAttribute::className(),
                         'redirectUrl'=> 'index',
                         'permission' => 'product.deleteother'
                        ],
            'bulk-delete' => ['class' => BulkDeleteAction::className(),
                              'modelClass' => ProductAttribute::className(),
                              'managerConfig' => $managerConfig,
                        ],
        ];
    }
    
    /**
     * Assign attributes to product
     * @param int $productId
     * @return string
     */
    public function actionAssign($productId)
    {
        $manager        = new ProductAttributeManager();
        $isValidProduct = ProductBusinessManager::getInstance()->isValidProductId($productId);
        if(!$isValidProduct)
        {
            throw new InvalidParamException("Invalid product id $productId");
        }
        $product        = ProductDAO::getById($productId, UsniAdaptor::app()->languageManager->selectedLanguage);
        $isPermissible  = true;
        if($product['created_by'] != UsniAdaptor::app()->user->getId())
        {
            $isPermissible      = UsniAdaptor::app()->user->can('product.updateother');
        }
        if(!$isPermissible)
        {
            throw new ForbiddenHttpException(\Yii::t('yii','You are not authorized to perform this action.'));
        }
        else
        {
            $attributeDTO  = new AssignAttributeDTO();
            $attributeDTO->setProduct($product);
            $manager->processAssignAttributes($productId, $attributeDTO);
            return $this->render('/assignAttributeEdit', ['formDTO' => $attributeDTO]);
        }
    }
    
    /**
     * Assign product attribute.
     * @return void
     */
    public function actionSaveAssignment()
    {
        $manager    = new ProductAttributeManager();
        $manager->processSaveAttributeAssignment(UsniAdaptor::app()->request->post('ProductAttributeMapping'));
        echo '';
    }
    
    /**
     * Modify attribute value
     * @param int $productId
     * @param int $attributeId
     * @return string
     */
    public function actionModify($productId, $attributeId)
    {
        $manager        = new ProductAttributeManager();
        $isValidProduct = ProductBusinessManager::getInstance()->isValidProductId($productId);
        if(!$isValidProduct)
        {
            throw new InvalidParamException("Invalid product id $productId");
        }
        $isPermissible  = true;
        $product        = ProductDAO::getById($productId, UsniAdaptor::app()->languageManager->selectedLanguage);
        if($product['created_by'] != UsniAdaptor::app()->user->getId())
        {
            $isPermissible      = UsniAdaptor::app()->user->can('product.updateother');
        }
        if(!$isPermissible)
        {
            throw new ForbiddenHttpException(\Yii::t('yii','You are not authorized to perform this action.'));
        }
        else
        {
            $attributeDTO  = new AssignAttributeDTO();
            $attributeDTO->setProduct($product);
            $manager->processEditAssignAttributes($productId, $attributeId, $attributeDTO);
            return $this->render('/assignAttributeEdit', ['formDTO' => $attributeDTO]);
        }
    }
    
    /**
     * Remove attribute value
     * @param int $productId
     * @param int $attributeId
     * @return string
     */
    public function actionRemove($productId, $attributeId)
    {
        $product        = ProductDAO::getById($productId, UsniAdaptor::app()->languageManager->selectedLanguage);
        $isPermissible  = true;
        if($product['created_by'] != UsniAdaptor::app()->user->getId())
        {
            $isPermissible      = UsniAdaptor::app()->user->can('product.deleteother');
        }
        if(!$isPermissible)
        {
            throw new ForbiddenHttpException(\Yii::t('yii','You are not authorized to perform this action.'));
        }
        else
        {
            $productAttributeMapping    = ProductAttributeMapping::getMapping($productId, $attributeId);
            $redirectUrl                = ['/catalog/products/attribute/assign', 'productId' => $productId];
            $productAttributeMapping->delete();
            return $this->redirect($redirectUrl);
        }
    }
}