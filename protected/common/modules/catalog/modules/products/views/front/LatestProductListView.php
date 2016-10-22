<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace products\views\front;

use frontend\utils\FrontUtil;
use products\utils\ProductUtil;
use usni\library\components\UiHtml;
use usni\UsniAdaptor;
use usni\library\views\UiView;
use common\modules\stores\utils\StoreUtil;
/**
 * LatestProductListView class file
 * 
 * @package products\views
 */
class LatestProductListView extends UiView
{   
    /**
     * @inheritdoc
     */
    protected function renderContent()
    {
        $theme      = FrontUtil::getThemeName();
        $file       = UsniAdaptor::getAlias('@themes/' . $theme . '/views/products/_latestproduct.php');
        $content    = null;
        $limitValue = StoreUtil::getSettingValue('catalog_items_per_page');
        $products   = ProductUtil::getStoreProducts($limitValue);
        if(!empty($products))
        {
            foreach($products as $product)
            {
                $innerContent = $this->getView()->renderPhpFile($file, ['model' => $product]);
                $content .= $innerContent;
            }
        }
        else
        {
            $content = UiHtml::tag('div', UsniAdaptor::t('products', 'There are no products available in the store'), ['class' => 'col-xs-12']);
        }
        return UiHtml::tag('div', $content, ['class' => 'row']);
    }
}