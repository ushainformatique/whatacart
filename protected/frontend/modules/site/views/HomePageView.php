<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace frontend\modules\site\views;

use products\views\front\LatestProductListView;
use frontend\modules\site\views\CarouselView;
use usni\UsniAdaptor;
use frontend\views\FrontPageView;
use usni\library\components\UiHtml;
/**
 * HomePageView class file
 *
 * @package frontend\modules\site\views
 */
class HomePageView extends FrontPageView
{
    /**
     * @inheritdoc
     */
    protected function renderInnerContent()
    {
        $productListView = new LatestProductListView();
        $productList     = $productListView->render();
        $carouselView    = new CarouselView();
        return  $carouselView->render() .
                UiHtml::tag('h3', UsniAdaptor::t('products', 'Latest Products')) .
                $productList;
    }
}
?>