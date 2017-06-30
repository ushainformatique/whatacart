<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace products\controllers;

use products\models\ProductOption;
use usni\UsniAdaptor;
use yii\filters\AccessControl;
use usni\library\web\actions\CreateAction;
use products\business\ProductOptionManager;
use usni\library\web\actions\UpdateAction;
use usni\library\web\actions\IndexAction;
use usni\library\web\actions\DeleteAction;
use usni\library\web\actions\BulkDeleteAction;
use usni\library\web\actions\ViewAction;
use yii\base\InvalidParamException;
use yii\web\ForbiddenHttpException;
use products\dto\AssignOptionDTO;
use products\dao\OptionDAO;
use products\business\Manager as ProductBusinessManager;
use products\dao\ProductDAO;
/**
 * OptionController class file.
 * 
 * @package products\controllers
 */
class OptionController extends \usni\library\web\Controller
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
                        'actions' => ['update', 'assign', 'get-product-values', 'save-assignment'],
                        'roles' => ['product.update'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['delete', 'bulk-delete'],
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
        $managerConfig = ['class'    => ProductOptionManager::className()];
        return [
            'create' => ['class' => CreateAction::className(),
                         'modelClass' => ProductOption::className(),
                         'updateUrl'  => 'update',
                         'managerConfig' => $managerConfig,
                         'viewFile' => '/productoption/create',
                        ],
            'update' => ['class' => UpdateAction::className(),
                         'modelClass' => ProductOption::className(),
                         'managerConfig' => $managerConfig,
                         'viewFile' => '/productoption/update',
                        ],
            'index'  => ['class' => IndexAction::className(),
                         'modelClass' => ProductOption::className(),
                         'managerConfig' => $managerConfig,
                         'viewFile' => '/productoption/index',
                        ],
            'view'   => ['class' => ViewAction::className(),
                         'modelClass' => ProductOption::className(),
                         'managerConfig' => $managerConfig,
                         'viewFile' => '/productoption/view'
                        ],
            'delete'   => ['class' => DeleteAction::className(),
                           'modelClass' => ProductOption::className(),
                           'redirectUrl'=> 'index',
                           'permission' => 'product.deleteother'
                        ],
            'bulk-delete' => ['class' => BulkDeleteAction::className(),
                              'modelClass' => ProductOption::className(),
                              'managerConfig' => $managerConfig,
                        ],
        ];
    }
    
    /**
     * Assign product options to product
     * @param int $productId
     * @return string
     */
    public function actionAssign($productId)
    {
        $manager        = new ProductOptionManager();
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
            $optionDTO          = new AssignOptionDTO();
            $manager->processAssignOptions($productId, $optionDTO);
            return $this->render('/assignOptionEdit', ['formDTO' => $optionDTO]);
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
        $language               = UsniAdaptor::app()->languageManager->selectedLanguage;
        $assignedOptionsMapping = OptionDAO::getAssignedOptionValues($productId, $optionId, $language);
        $optionValues           = OptionDAO::getOptionValues($optionId, $language);
        echo $this->renderAjax('/_assignOptionValues', ['optionValues' => $optionValues, 'assignedOptionsMapping' => $assignedOptionsMapping]);
    }
    
    /**
     * Save option value assignment for the option.
     * @return void
     */
    public function actionSaveAssignment()
    {
        $manager    = new ProductOptionManager();
        $postData   = UsniAdaptor::app()->request->post('ProductOptionMapping');
        $manager->processSaveOptionValueAssignment($postData);
        $assignedOptions = ProductBusinessManager::getInstance()->getAssignedOptions($postData['product_id']);
        echo $this->renderAjax('/_manageOptionValuesSubView', ['assignedOptions' => $assignedOptions]);
    }
}