<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace products\views\front;

use usni\library\components\UiListView;
use common\modules\catalog\components\ListViewWidget;
use products\utils\ProductUtil;
use frontend\utils\FrontUtil;
use common\modules\stores\utils\StoreUtil;
/**
 * RelatedProductListView class file.
 * @package products\views\front
 */
class RelatedProductListView extends UiListView
{
    /**
     * Product for which related products has to be fetched
     * @var int 
     */
    public $productId;
    
    /**
     * @inheritdoc
     */
    protected function getItemView()
    {
        $theme = FrontUtil::getThemeName();
        return '@themes/' . $theme . '/views/products/_relatedproductItem';
    }

    /**
     * @inheritdoc
     */
    protected function getDataProvider()
    {
        $allModels = ProductUtil::getRelatedProducts($this->productId);
        $this->dataProvider = new \yii\data\ArrayDataProvider(['allModels' => $allModels, 'pagination' => false, 'sort' => false]);
        return $this->dataProvider;
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
        return 'related-product-listview';
    }
    
    /**
     * @inheritdoc
     */
    protected function getListViewWidgetPath()
    {
        return ListViewWidget::className();
    }
    
    /**
     * @inheritdoc
     */
    protected function getLayout()
    {
        return "{pager}\n{items}\n{pager}";
    }
    
    /**
     * @inheritdoc
     */
    protected function getViewParams()
    {
        $imageWidth     = StoreUtil::getImageSetting('related_product_image_width', 80);
        $imageHeight    = StoreUtil::getImageSetting('related_product_image_height', 80);
        return ['imageWidth' => $imageWidth, 'imageHeight' => $imageHeight];
    }
}