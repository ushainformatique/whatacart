<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace products\business;

use usni\library\business\Manager;
use products\models\ProductReview;
use usni\UsniAdaptor;
use usni\library\dto\GridViewDTO;
use usni\library\dataproviders\ArrayRecordDataProvider;
use products\dao\ProductDAO;
use usni\library\utils\ArrayUtil;
use yii\base\InvalidParamException;
/**
 * ProductReviewManager class file.
 *
 * @package products\business
 */
class ProductReviewManager extends Manager
{
    /**
     * inheritdoc
     */
    public function processList($gridViewDTO)
    {
        parent::processList($gridViewDTO);
        $dropdownData = $this->getProductDropDownData();
        $gridViewDTO->setProductDropDownData($dropdownData);
    }

    /**
     * Get product drop down data.
     * @return array
     */
    private function getProductDropDownData()
    {
        return ArrayUtil::map(ProductDAO::getAll($this->language), 'id', 'name');
    }

    /**
     * Process approve.
     * @param integer $id
     */
    public function processApprove($id)
    {
        $productReview = $this->loadModel(ProductReview::className(), $id);
        $productReview->scenario = 'approve';
        $productReview->status = ProductReview::STATUS_APPROVED;
        $productReview->save();
    }

    /**
     * Process unapprove.
     * @param integer $id
     */
    public function processUnapprove($id)
    {
        $productReview = $this->loadModel(ProductReview::className(), $id);
        $productReview->scenario = 'unapprove';
        $productReview->status = ProductReview::STATUS_PENDING;
        $productReview->save();
    }

    /**
     * Process spam.
     * @param integer $id
     */
    public function processSpam($id)
    {
        $productReview = $this->loadModel(ProductReview::className(), $id);
        $productReview->scenario = 'spam';
        $productReview->status = ProductReview::STATUS_SPAM;
        $productReview->save();
    }

    /**
     * Process remove spam.
     * @param integer $id
     */
    public function processRemoveSpam($id)
    {
        $productReview = $this->loadModel(ProductReview::className(), $id);
        $productReview->scenario = 'removespam';
        $productReview->status = ProductReview::STATUS_PENDING;
        $productReview->save();
    }

    /**
     * Process delete from grid.
     * @param integer $id
     */
    public function processDeleteFromGrid($id)
    {
        $productReview = $this->loadModel(ProductReview::className(), $id);
        $productReview->status = ProductReview::STATUS_DELETED;
        $productReview->scenario = 'delete';
        $productReview->save();
    }

    /**
     * inheritdoc
     */
    public function deleteModel($model)
    {
        $model->status = ProductReview::STATUS_DELETED;
        $model->scenario = 'bulkdelete';
        $model->save();
    }

    /**
     * Process bulk approve.
     * @param array $selectedItemsIds
     */
    public function processBulkApprove($selectedItemsIds)
    {
        $this->updateStatusForSelectedRecords($selectedItemsIds, ProductReview::STATUS_PENDING, ProductReview::STATUS_APPROVED);
    }
    
    /**
     * Process bulk unapprove.
     * @param array $selectedItemsIds
     */
    public function processBulkUnapprove($selectedItemsIds)
    {
        $this->updateStatusForSelectedRecords($selectedItemsIds, ProductReview::STATUS_APPROVED, ProductReview::STATUS_PENDING);
    }

    /**
     * Update status for selected records.
     * @param array $selectedItemsIds
     * @param int $sourceStatus
     * @param int $targetStatus
     * @return void
     */
    public function updateStatusForSelectedRecords($selectedItemsIds, $sourceStatus, $targetStatus)
    {
        foreach ($selectedItemsIds as $itemId)
        {
            $productReview = ProductReview::findOne($itemId);
            if (UsniAdaptor::app()->authorizationManager->checkAccess($this->userId, 'productreview.approve'))
            {
                if ($productReview['status'] == $sourceStatus)
                {
                    UsniAdaptor::db()->createCommand()
                        ->update(ProductReview::tableName(), ['status' => $targetStatus], 'id = :id', [':id' => $productReview['id']])->execute();
                }
            }
        }
    }

    /**
     * inheritdoc
     */
    public function loadModel($modelClass, $id)
    {
        $model = $modelClass::findOne($id);
        if ($model === null)
        {
            throw new InvalidParamException("Object not found: $id");
        }
        return $model;
    }
    
    /**
     * Process trash list.
     * @param GridViewDTO $gridViewDTO
     */
    public function processTrashList($gridViewDTO)
    {
        $dataProvider = $this->getTrashDataProvider();
        $gridViewDTO->setDataProvider($dataProvider);
    }
    
    /**
     * Get trash dataprovider.
     * @return ArrayRecordDataProvider
     */
    private function getTrashDataProvider()
    {
        $query          = new \yii\db\Query();
        $tableName      = UsniAdaptor::tablePrefix() . 'product_review';
        $trTableName    = UsniAdaptor::tablePrefix() . 'product_review_translated';
        $trProductTable = UsniAdaptor::tablePrefix() . 'product_translated';
        $query->select('tpr.*, tprt.review, pt.name AS product_name')
              ->from("$tableName tpr, $trTableName tprt, $trProductTable pt")
              ->where('tpr.status = :status AND tpr.id = tprt.owner_id AND tprt.language = :lang AND tpr.product_id = pt.owner_id AND '
                    . 'pt.language = :plang', 
                     [':status' => ProductReview::STATUS_DELETED, ':lang' => $this->language, ':plang' => $this->language]);
        $canAccessOwnedRecordOnly = UsniAdaptor::app()->authorizationManager->canAccessOwnedRecordsOnly(UsniAdaptor::app()->user->getId(), 
                                                                                                        'productreview', 
                                                                                                        []);
        if($canAccessOwnedRecordOnly)
        {
            $query->andFilterWhere(['tpr.created_by' => $this->userId]);
        }
        return new ArrayRecordDataProvider([
                                                'query' => $query,
                                                'key'   => 'id',
                                                'sort'  => ['attributes' => ['name', 'review', 'product_id']]
                                          ]);
    }
    
    /**
     * Process delete from trash
     * @param integer $id
     */
    public function processDeleteFromTrash($id)
    {
        $productReview  = $this->loadModel(ProductReview::className(), $id);
        $productReview->delete();
    }
    
    /**
     * Process trash bulk delete.
     * @param array $selectedItems
     */
    public function processTrashBulkDelete($selectedItems)
    {
        foreach ($selectedItems as $item)
        {
            $model = $this->loadModel(ProductReview::className(), intval($item));
            //Check if allowed to delete
            if(UsniAdaptor::app()->authorizationManager->checkAccess($this->userId, 'productreview.delete'))
            {
                $model->delete();
            }
        }
    }
    
    /**
     * Process undo.
     * @param integer $id
     */
    public function processUndo($id)
    {
        $productReview = $this->loadModel(ProductReview::className(), $id);
        $productReview->scenario    = 'undo';
        $productReview->status      = ProductReview::STATUS_PENDING;
        $productReview->save();
    }
}
