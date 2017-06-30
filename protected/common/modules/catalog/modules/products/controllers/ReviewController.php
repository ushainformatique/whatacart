<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace products\controllers;

use products\models\ProductReview;
use usni\UsniAdaptor;
use usni\library\web\actions\IndexAction;
use yii\filters\AccessControl;
use products\dto\ProductReviewGridViewDTO;
use products\business\ProductReviewManager;
use usni\library\web\actions\BulkDeleteAction;
/**
 * Review controller for products.
 * 
 * @package products\controllers
 */
class ReviewController extends \usni\library\web\Controller
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
                        'roles' => ['productreview.manage'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['approve', 'unapprove', 'bulk-approve', 'bulk-unapprove'],
                        'roles' => ['productreview.approve'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['spam', 'remove-spam'],
                        'roles' => ['productreview.spam'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['delete', 'bulk-delete', 'delete-from-grid', 'delete-from-trash', 'trash-bulk-delete', 'trash', 'undo'],
                        'roles' => ['productreview.delete'],
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
        $managerConfig = ['class'     => ProductReviewManager::className()];
        return [
            'index'  => ['class' => IndexAction::className(),
                         'modelClass' => ProductReview::className(),
                         'managerConfig' => $managerConfig,
                         'viewFile' => '/productreview/index',
                         'dtoClass' => ProductReviewGridViewDTO::className()
                        ],
            'bulk-delete' => ['class' => BulkDeleteAction::className(),
                              'modelClass' => ProductReview::className(),
                              'managerConfig' => $managerConfig,
                        ],
        ];
    }
    
    /**
     * Approve a product review.
     * @param integer $id ID of the model to be approved.
     * @return void
     */
    public function actionApprove($id)
    {
        if(UsniAdaptor::app()->request->isAjax)
        {
            ProductReviewManager::getInstance()->processApprove($id);
        }
    }

    /**
     * Unapprove a product review.
     * @param integer $id ID of the model to be approved.
     * @return void
     */
    public function actionUnapprove($id)
    {
        if(UsniAdaptor::app()->request->isAjax)
        {
            ProductReviewManager::getInstance()->processUnapprove($id);
        }
    }

    /**
     * Mark product review as spam.
     * @param integer $id ID of the model to be approved.
     * @return void
     */
    public function actionSpam($id)
    {
        if(UsniAdaptor::app()->request->isAjax)
        {
            ProductReviewManager::getInstance()->processSpam($id);
        }
    }

    /**
     * Remove spam from the product review.
     * @param integer $id ID of the model to be approved.
     * @return void
     */
    public function actionRemoveSpam($id)
    {
        if(UsniAdaptor::app()->request->isAjax)
        {
            ProductReviewManager::getInstance()->processRemoveSpam($id);
        }
    }

    /**
     * Delete a product review.
     * @param integer $id ID of the model to be processed.
     * @return void
     */
    public function actionDeleteFromGrid($id)
    {
        ProductReviewManager::getInstance()->processDeleteFromGrid($id);
        return $this->redirect(UsniAdaptor::createUrl('catalog/products/review/index'));
    }

    /**
     * Perform BulkApprove on product review gridview
     * @return void
     */
    public function actionBulkApprove()
    {
        if (UsniAdaptor::app()->request->isAjax && isset($_GET['id']))
        {
            ProductReviewManager::getInstance()->processBulkApprove($_GET['id']);
        }
    }

    /**
     * Perform BulkUnapprove on product review gridview
     * @return void
     */
    public function actionBulkUnapprove()
    {
        
        if (UsniAdaptor::app()->request->isAjax && isset($_GET['id']))
        {
            ProductReviewManager::getInstance()->processBulkUnapprove($_GET['id']);
        }
    }
    
    /**
     * Comments trash Grid View
     * @return 
     */
    public function actionTrash()
    {
        $gridviewDTO        = new ProductReviewGridViewDTO();
        ProductReviewManager::getInstance()->processTrashList($gridviewDTO);
        return $this->render('/productreview/trashindex', ['gridViewDTO' => $gridviewDTO]);
    }
    
    /**
     * Delete model from trash.
     * @param int $id
     * @return void
     */
    public function actionDeleteFromTrash($id)
    {
        ProductReviewManager::getInstance()->processDeleteFromTrash($id);
        $this->redirect(UsniAdaptor::createUrl('catalog/products/review/trash'));
    }
    
    /**
     * Perform BulkDelete on trash gridview
     * 
     * @return void
     */
    public function actionTrashBulkDelete()
    {
        if (UsniAdaptor::app()->request->isAjax && isset($_GET['id']))
        {
            ProductReviewManager::getInstance()->processTrashBulkDelete($_GET['id']);
        }
    }
    
    
    /**
     * Undo deleted model.
     * @param int $id
     * @return void
     */
    public function actionUndo($id)
    {
        ProductReviewManager::getInstance()->processUndo($id);
        $this->redirect(UsniAdaptor::createUrl('catalog/products/review/index'));
    }
}
