<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace wishlist\views;

use customer\views\front\AccountPageView;
use wishlist\views\WishlistSubView;
use usni\library\components\UiHtml;
use usni\UsniAdaptor;
/**
 * DetailView class file.
 * @package wishlist\views
 */
class DetailView extends AccountPageView
{
    /**
     * @inheritdoc
     */
    protected function renderInnerContent()
    {
        $view = new WishlistSubView();
        return UiHtml::tag('h2', UsniAdaptor::t('wishlist', 'My Wish List')) .  $view->render();
    }
    
    /**
     * @inheritdoc
     */
    protected function renderLeftColumn()
    {
        if($this->model != null)
        {
            return parent::renderLeftColumn();
        }
        return null;
    }
}