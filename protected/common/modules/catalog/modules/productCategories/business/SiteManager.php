<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace productCategories\business;

use productCategories\dto\ProductCategoryListViewDTO;
use productCategories\dao\ProductCategoryDAO;
use frontend\models\SearchForm;
use products\behaviors\PriceBehavior;
use products\behaviors\ProductBehavior;
use frontend\business\SearchManager;
use common\modules\stores\dao\StoreDAO;
use productCategories\models\ProductCategory;
/**
 * SiteManager class file.
 *
 * @package productCategories\business
 */
class SiteManager extends Manager
{
    /**
     * @var integer 
     */
    public $dataCategoryId;
    
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            PriceBehavior::className(),
            ProductBehavior::className()
        ];
    }
    
    /**
     * Process product category view. 
     * @param ProductCategoryListViewDTO $listViewDTO
     */
    public function processView($listViewDTO)
    {
        $id             = $listViewDTO->getId();
        $productCat     = ProductCategoryDAO::getById($id, $this->language);
        $searchModel    = new SearchForm(['categoryId' => $id]);
        $listViewDTO->setSearchModel($searchModel);
        $listViewDTO->setProductCategory($productCat);
        $listViewDTO->setDataprovider(SearchManager::getInstance()->getDataProvider($listViewDTO));
    }
    
    /**
     * inheritdoc
     */
    public function isValidCategory($productCategoryId)
    {
        $dataCategoryId    = StoreDAO::getDataCategoryId($this->selectedStoreId);
        $count             = ProductCategory::find()->where('data_category_id = :dci AND id = :id AND status = :status', [':dci' => $dataCategoryId, 
                                                            ':id' => $productCategoryId, ':status' => ProductCategory::STATUS_ACTIVE])->count();
        if(intval($count) > 0)
        {
            return true;
        }
        return false;
    }
    
    /**
     * @inheritdoc
     */
    public function getMultiLevelSelectOptions($model, $checkPermission = true)
    {
        $dataCategoryId     = StoreDAO::getDataCategoryId($this->selectedStoreId);
        $model->data_category_id = $dataCategoryId;
        $model->nodeList    = $model->descendants(0, false);
        return $model->getMultiLevelSelectOptions('name');
    }
}