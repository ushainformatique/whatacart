<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace cart\views;

use usni\UsniAdaptor;
use usni\library\components\UiHtml;
use frontend\views\FrontPageView;
use usni\library\utils\FlashUtil;
/**
 * DetailView class file.
 * @package cart\views
 */
class DetailView extends FrontPageView
{
    /**
     * @inheritdoc
     */
    protected function renderInnerContent()
    {
        $viewHelper         = UsniAdaptor::app()->getModule('cart')->viewHelper;
        $subView            = $viewHelper->getInstance('cartSubView');
        $detail             = $subView->render();
        $detail             = UiHtml::tag('div', $detail, ['id' => 'shopping-container']);
        return FlashUtil::render('outOfStockCheckoutNowAllowed', 'alert alert-danger') . UiHtml::tag('h2', UsniAdaptor::t('cart', 'Shopping Cart')) .  $detail;
    }
}