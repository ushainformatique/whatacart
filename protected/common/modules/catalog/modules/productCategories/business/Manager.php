<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace productCategories\business;

use usni\library\managers\UploadInstanceManager;
use usni\library\utils\FileUploadUtil;
use usni\UsniAdaptor;
use productCategories\dao\ProductCategoryDAO;
use yii\base\InvalidParamException;
use common\modules\dataCategories\dao\DataCategoryDAO;
use common\modules\stores\dao\StoreDAO;
use usni\library\utils\ArrayUtil;
use productCategories\models\ProductCategory;
/**
 * Manager class file.
 *
 * @package productCategories\business
 */
class Manager extends \common\business\Manager
{
    /**
     * @inheritdoc
     */
    public function beforeModelSave($model)
    {
        if(parent::beforeModelSave($model))
        {
            $config = [
                            'model'             => $model,
                            'attribute'         => 'image',
                            'uploadInstanceAttribute' => 'uploadInstance',
                            'type'              => 'image',
                            'savedAttribute'    => 'savedImage',
                            'fileMissingError'  => UsniAdaptor::t('application', 'Please upload image'),
                      ];
            $uploadInstanceManager = new UploadInstanceManager($config);
            $result = $uploadInstanceManager->processUploadInstance();
            if($result === false)
            {
                return false;
            }
            return true;
        }
        return false;
    }

    /**
     * @inheritdoc
     */
    public function afterModelSave($model)
    {
        if($model->image != null)
        {
            $config = [
                            'model'             => $model, 
                            'attribute'         => 'image', 
                            'uploadInstance'    => $model->uploadInstance, 
                            'savedFile'         => $model->savedImage
                      ];
            FileUploadUtil::save('image', $config);
        }
        return true;
    }
    
    /**
     * inheritdoc
     */
    public function beforeAssigningPostData($model)
    {
        $model->savedImage = $model->image;
    }
    
    /**
     * inheritdoc
     */
    public function processEdit($formDTO)
    {
        parent::processEdit($formDTO);
        $dataCategories = $this->getDataCategories();
        $formDTO->setDataCategories($dataCategories);
        $parentDropdownOptions = $this->getMultiLevelSelectOptions($formDTO->getModel());
        $formDTO->setParentDropdownOptions($parentDropdownOptions);
    }
    
   /**
     * Get data categories.
     * @return array
     */
    private function getDataCategories()
    {
        $dataCategories = DataCategoryDAO::getAll($this->language);
        return ArrayUtil::map($dataCategories, 'id', 'name');
    }
    
    /**
     * Get multi level select options
     * @param ProductCategory $model
     * @param boolean $checkPermission
     * @return array
     */
    public function getMultiLevelSelectOptions($model, $checkPermission = true)
    {
        $canAccessOthersModel = true;
        if($model->isNewRecord)
        {
            $model->created_by = $this->userId;
        }        
        $dataCategoryId     = StoreDAO::getDataCategoryId($this->selectedStoreId);
        $model->data_category_id = $dataCategoryId;
        $model->nodeList    = $model->descendants(0, false);
        if($checkPermission)
        {
            $canAccessOthersModel  = UsniAdaptor::app()->authorizationManager->checkAccess($this->userId, 'productcategory.updateother');
        }
        return $model->getMultiLevelSelectOptions('name', !$canAccessOthersModel);
    }
    
    /**
     * Check if product category is valid with the current store selected.
     * @param integer $productCategoryId
     * @return boolean
     */
    public function isValidCategory($productCategoryId)
    {
        $dataCategoryId     = StoreDAO::getDataCategoryId($this->selectedStoreId);
        $count              = ProductCategory::find()->where('data_category_id = :dci AND id = :id', [':dci' => $dataCategoryId, 
                                                                                                      ':id' => $productCategoryId])->count();
        if(intval($count) > 0)
        {
            return true;
        }
        return false;
    }
    
    /**
     * inheritdoc
     */
    public function getBrowseModels($modelClass)
    {
        $dataCategoryId = StoreDAO::getDataCategoryId($this->selectedStoreId);
        return ProductCategoryDAO::getAll($this->language, $dataCategoryId);
    }
    
    /**
     * inheritdoc
     */
    public function loadModel($modelClass, $id)
    {
        $model      = ProductCategoryDAO::getById($id, $this->language);
        if ($model === null)
        {
            throw new InvalidParamException("Invalid product category: $id");
        }
        return $model;
    }
    
    /**
     * inheritdoc
     */
    public function processDetail($detailViewDTO)
    {
        $isValid = $this->isValidCategory($detailViewDTO->getId());
        if($isValid == false)
        {
            throw new InvalidParamException(UsniAdaptor::t('productCategories', "Invalid product category"));
        }
        parent::processDetail($detailViewDTO);
        $model          = $detailViewDTO->getModel();
        $parent         = ProductCategoryDAO::getParentName($model['parent_id'], $this->language);
        $dataCategory   = DataCategoryDAO::getById($model['data_category_id'], $this->language);
        if(!empty($parent))
        {
            $model['parent_name'] = $parent;
        }
        else
        {
            $model['parent_name'] = UsniAdaptor::t('application', '(not set)');
        }
        if(!empty($dataCategory))
        {
            $model['data_category'] = $dataCategory['name'];
        }
        else
        {
            $model['data_category'] = UsniAdaptor::t('application', '(not set)');
        }
        $detailViewDTO->setModel($model);
    }
    
    /**
     * Prepare menu items by data category.
     * @param int $dataCategoryId
     * @param int $parentId
     * @param int $isChildrenOnly If only children's have to be fetched
     * @return boolean
     */
    public function prepareMenuItems($dataCategoryId, $parentId = 0, $isChildrenOnly = false)
    {
        $recordsData    = [];
        $records        = ProductCategoryDAO::getChildrens($parentId, $this->language, $dataCategoryId);
        if(!$isChildrenOnly)
        {
            foreach($records as $record)
            {
                $hasChildren    = false;
                $childrens      = $this->prepareMenuItems($dataCategoryId, $record['id'], false);
                if(count($childrens) > 0)
                {
                    $hasChildren = true;
                    $record['hasChildren'] = $hasChildren;
                    $record['children'] = $childrens;
                }
                $recordsData[] = $record;
            }
            return $recordsData;
        }
        else
        {
            return $records;
        }
    }
}