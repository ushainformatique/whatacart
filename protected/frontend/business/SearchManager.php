<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace frontend\business;

use usni\UsniAdaptor;
use usni\library\utils\ArrayUtil;
use productCategories\models\ProductCategory;
use products\models\Product;
use frontend\dto\ListViewDTO;
use products\behaviors\ProductBehavior;
use yii\data\Sort;
use usni\library\dataproviders\ArrayRecordDataProvider;
/**
 * Performs logic related to product category, keyword, manufacturer and tag search
 *
 * @package frontend\business
 */
class SearchManager extends \common\business\Manager
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [ProductBehavior::className()];
    }
    
    /**
     * Get data provider.
     * @param ListViewDTO $listViewDTO
     * @return ArrayRecordDataProvider
     */
    public function getDataProvider($listViewDTO)
    {
        $query   = $this->resolveDataProviderQuery($listViewDTO->getSearchModel(), $listViewDTO->getDataCategoryId());
        $sort   = new Sort([
                'defaultOrder' => $this->resolveDataProviderSort($listViewDTO->getSortingOption(), $listViewDTO->getDataCategoryId()),
                'attributes' => [
                                    'name' =>  [
                                                'asc' => ['name' => SORT_ASC],
                                                'desc' => ['name' => SORT_DESC],
                                                'label' => UsniAdaptor::t('application', 'Name')
                                               ],
                                    'price' => [
                                                'asc' => ['price' => SORT_ASC],
                                                'desc' => ['price' => SORT_DESC],
                                                'label' => UsniAdaptor::t('products', 'Price')
                                               ]
                                ],
            ]);
        $dataProvider = new ArrayRecordDataProvider(['query' => $query,
                                                        'pagination' => [
                                                                           'pageSize' => $this->resolvePageSize($listViewDTO->getPageSize()),
                                                                        ],
                                                        'sort' => $sort
                                                         ]);
        $models         = $dataProvider->getModels();
        foreach($models as $index => $model)
        {
            $finalPriceExcludingTax             = $this->getFinalPrice($model);
            $model['finalPriceExcludingTax']    = $finalPriceExcludingTax;
            $model['tax']                       = $this->getTaxAppliedOnProduct($model, $finalPriceExcludingTax);
            $model['requiredOptionsCount']      = $this->getRequiredOptionsCount($model['id']);
            $models[$index]                     = $model;
        }
        $dataProvider->setModels($models);
        return $dataProvider;
    }
    
    /**
     * @inheritdoc
     */
    protected function resolvePageSize($size)
    {
        if($size == null)
        {
            $size = UsniAdaptor::app()->storeManager->getSettingValue('catalog_items_per_page');
        }
        return $size;
    }
    
    /**
     * Resolve data provider sort.
     * @param string $sortingOption
     * @return array
     */
    protected function resolveDataProviderSort($sortingOption)
    {
        if(!empty($sortingOption))
        {
            if($sortingOption == 'namedesc')
            {
                return ['name' => SORT_DESC];
            }
            elseif($sortingOption == 'nameasc')
            {
                return ['name' => SORT_ASC];
            }
            elseif($sortingOption == 'priceasc')
            {
                return ['price' => SORT_ASC];
            }
            elseif($sortingOption == 'pricedesc')
            {
                return ['price' => SORT_DESC];
            }
        }
        return [];
    }
    
    /**
     * Resolve data provider query.
     * @param \yii\db\Query $query
     * @param SearchForm $searchModel
     * @param int $dataCategoryId
     */
    protected function resolveProductCategoryQuery($query, $searchModel, $dataCategoryId)
    {
        $categoryId       = $searchModel->categoryId;
        $prCatTable       = ProductCategory::tableName();
        $language         = $this->language;
        if($categoryId == null)
        {
            $from           = $query->from;
            $query->from    = ArrayUtil::merge($from, [$prCatTable . ' tpc']);
            $query->andWhere('tpc.status = :status AND tpcm.data_category_id = :dci AND tpcm.category_id = tpc.id AND tpcm.product_id = tp.id '
                       . 'AND tp.status = :status AND tp.id = tpt.owner_id AND tpt.language = :lan1', 
                        [':status' => ProductCategory::STATUS_ACTIVE, ':dci' => $dataCategoryId, ':lan1' => $language]);
        }
        else
        {
            $query->andWhere('tpcm.data_category_id = :dci AND tpcm.category_id = :cid AND tpcm.product_id = tp.id AND tp.status = :status AND tp.id = tpt.owner_id AND tpt.language = :lan1', 
            [':dci' => $dataCategoryId, ':cid' => $categoryId, ':lan1' => $language, ':status' => Product::STATUS_ACTIVE]);
        }
    }
    
    /**
     * Resolve data provider query.
     * @param SearchForm $searchModel
     * @param int $dataCategoryId
     * @return \yii\db\Query
     */
    protected function resolveDataProviderQuery($searchModel, $dataCategoryId)
    {
        $language               = $this->language;
        $keyword                = $searchModel->keyword;
        $manId                  = $searchModel->manufacturerId;
        $tag                    = $searchModel->tag;
        $productTable           = UsniAdaptor::tablePrefix() . 'product';
        $mappingTable           = UsniAdaptor::tablePrefix() . 'product_category_mapping';
        $transTable             = UsniAdaptor::tablePrefix() . 'product_translated';
        $query                  = new \yii\db\Query();
        $query->select('tp.*, tpt.name, tpt.description')->from([$productTable . ' tp', $transTable . ' tpt', $mappingTable . ' tpcm']);
        $this->resolveProductCategoryQuery($query, $searchModel, $dataCategoryId);
        if($manId != null)
        {
            $query->andWhere('tp.manufacturer = :mid', [':mid' => $manId]);
        }
        if($tag != null)
        {
            $from = $query->from;
            $tagMappingTable    = UsniAdaptor::tablePrefix() . 'product_tag_mapping';
            $tagTrTable         = UsniAdaptor::tablePrefix() . 'tag_translated';
            $query->from        = ArrayUtil::merge($from, [$tagMappingTable . ' tmt', $tagTrTable . ' tagTr']);
            $query->andWhere('tagTr.name = :tag AND tagTr.owner_id = tmt.tag_id AND tmt.product_id = tp.id AND tagTr.language = :lan2', 
                            [':tag' => $tag, ':lan2' => $language]);
        }
        if($keyword != null)
        {
            $query = $query->andWhere('(tpt.name like :keyword OR alias like :keyword OR description like :keyword)', [':keyword' => '%' . $keyword . '%']);
        }
        $query->groupBy('tp.id');
        return $query;
    }
}
