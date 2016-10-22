<?php
namespace common\modules\order\views;

use usni\library\views\UiView;
use usni\library\components\UiHtml;
use cart\views\AdminCartSubView;
/**
 * Order cart items view
 * @package products\views
 */
class OrderCartItemsView extends UiView
{
    /**
     * @inheritdoc
     */
    protected function renderContent()
    {
        $cartSubView    = new AdminCartSubView();
        return UiHtml::tag('div', $cartSubView->render(), ['id' => 'order-cart-products']);
    }
}