<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace frontend\views\common;

use usni\library\components\UiListView;
use frontend\utils\FrontUtil;
use yii\widgets\Pjax;
use frontend\components\LinkPager;
use products\models\Product;
use products\models\ProductTranslated;
use products\models\ProductCategoryMapping;
use yii\data\Sort;
use usni\UsniAdaptor;
use products\models\ProductTagMapping;
use products\models\TagTranslated;
use usni\library\utils\ArrayUtil;
use usni\library\dataproviders\ArrayRecordDataProvider;
use common\modules\stores\utils\StoreUtil;
use productCategories\models\ProductCategory;
/**
 * SearchResultsListView class file
 *
 * @package frontend\views\common
 */
class SearchResultsListView extends UiListView
{
    /**
     * @var SearchForm.
     */
	public $searchFormModel;
    
    /**
     * @inheritdoc
     */
    protected function getItemView()
    {
        $theme = FrontUtil::getThemeName();
        return '@themes/' . $theme . '/views/productCategories/_listProductItem';
    }

    /**
     * @inheritdoc
     */
    protected function shouldRenderTitle()
    {
        return false;
    }

    /**
     * @inheritdoc
     */
    protected function getListViewId()
    {
        return 'search-results-list-view';
    }

    /**
     * @inheritdoc
     */
    protected function shouldRenderSearchForm()
    {
        return true;
    }
    
    /**
     * @inheritdoc
     */
    protected function resolvePageSize($metadata)
    {
        $size  = UsniAdaptor::app()->request->get('showItemsPerPage');
        if($size == null)
        {
            $size = StoreUtil::getSettingValue('catalog_items_per_page');
        }
        return $size;
    }

    /**
     * Resolve data provider sort
     * @return array
     */
    protected function resolveDataProviderSort()
    {
        $sortingOption  = UsniAdaptor::app()->request->get('sort');
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
     * @inheritdoc
     */
    protected function getLayout()
    {
        return "<div class='row'>{items}</div><div class='row'><div class='col-sm-6 text-left'>{pager}</div><div class='col-sm-6 text-right'>{summary}</div></div>";
    }
    
    /**
     * @inheritdoc
     */
    protected function renderContent()
    {
        $content = null;
        ob_start();
        Pjax::begin(['id' => $this->pjaxContainerId, 'enablePushState' => false, 'timeout' => 2000]);
        echo $this->renderList();
        Pjax::end();
        $output     = ob_get_clean();
        $content   .= $output;
        return $content;
    }
    
    /**
     * @inheritdoc
     */
    protected function getOptions()
    {
        return ['id' => $this->getListViewId()];
    }
    
    /**
     * @inheritdoc
     */
    protected function getItemOptions()
    {
        return ['tag' => false];
    }
    
    /**
     * @inheritdoc
     */
    protected function getPager()
    {
        return ['class' => LinkPager::className()];
    }
    
    /**
     * @inheritdoc
     */
    protected function resolveDataProviderQuery()
    {
        $language               = UsniAdaptor::app()->languageManager->getDisplayLanguage();
        $keyword                = $this->searchFormModel->keyword;
        $manId                  = $this->searchFormModel->manufacturerId;
        $tag                    = $this->searchFormModel->tag;
        $productTable           = Product::tableName();
        $mappingTable           = ProductCategoryMapping::tableName();
        $transTable             = ProductTranslated::tableName();
        $query                  = Product::find();
        $query->select('tp.*, tpt.name, tpt.description')->from([$productTable . ' tp', $transTable . ' tpt', $mappingTable . ' tpcm']);
        $this->resolveProductCategoryQuery($query);
        if($manId != null)
        {
            $query->andWhere('tp.manufacturer = :mid', [':mid' => $manId]);
        }
        if($tag != null)
        {
            $from = $query->from;
            $tagMappingTable    = ProductTagMapping::tableName();
            $tagTrTable         = TagTranslated::tableName();
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
    
    /**
     * Resolve data provider query
     * @param Query $query
     */
    protected function resolveProductCategoryQuery($query)
    {
        $categoryId       = $this->searchFormModel->categoryId;
        $prCatTable       = ProductCategory::tableName();
        $dataCategoryId   = UsniAdaptor::app()->storeManager->getSelectedStoreDataCategory();
        $language         = UsniAdaptor::app()->languageManager->getDisplayLanguage();
        if($categoryId == null)
        {
            $from           = $query->from;
            $query->from    = ArrayUtil::merge($from, [$prCatTable . ' tpc']);
            $query->where('tpc.status = :status AND tpcm.data_category_id = :dci AND tpcm.category_id = tpc.id AND tpcm.product_id = tp.id '
                       . 'AND tp.status = :status AND tp.id = tpt.owner_id AND tpt.language = :lan1', 
                        [':status' => ProductCategory::STATUS_ACTIVE, ':dci' => $dataCategoryId, ':lan1' => $language]);
        }
        else
        {
            $query->where('tpcm.data_category_id = :dci AND tpcm.category_id = :cid AND tpcm.product_id = tp.id AND tp.status = :status AND tp.id = tpt.owner_id AND tpt.language = :lan1', 
            [':dci' => $dataCategoryId, ':cid' => $categoryId, ':lan1' => $language, ':status' => Product::STATUS_ACTIVE]);
        }
    }


    /**
     * @inheritdoc
     */
    protected function getDataProvider()
    {   
        $query = $this->resolveDataProviderQuery();
        $sort = new Sort([
                'defaultOrder' => $this->resolveDataProviderSort(),
                'attributes' => [
                                    'name' =>  [
                                                'asc' => ['name' => SORT_ASC],
                                                'desc' => ['name' => SORT_DESC],
                                                'label' => $this->model->getAttributeLabel('name')
                                               ],
                                    'price' => [
                                                'asc' => ['price' => SORT_ASC],
                                                'desc' => ['price' => SORT_DESC],
                                                'label' => $this->model->getAttributeLabel('price')
                                               ]
                                ],
            ]);
        $this->dataProvider =  new ArrayRecordDataProvider(['query' => $query,
                                                                'pagination' => [
                                                                                   'pageSize' => $this->resolvePageSize([]),
                                                                                ],
                                                                'sort' => $sort
                                                         ]);
        return $this->dataProvider;
    }
    
    /**
     * @inheritdoc
     */
    protected function getViewParams()
    {
        $imageWidth     = StoreUtil::getImageSetting('product_list_image_width', 150);
        $imageHeight    = StoreUtil::getImageSetting('product_list_image_height', 150);
        return ['imageWidth' => $imageWidth, 'imageHeight' => $imageHeight];
    }
}