<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace frontend\views\common;

use usni\library\views\UiView;
use frontend\utils\FrontUtil;
use frontend\views\common\LanguageSelectionView;
use usni\library\utils\ApplicationUtil;
use usni\UsniAdaptor;
use frontend\views\common\SearchNavView;
/**
 * HeaderView class file.
 *
 * @package frontend\views\commmon
 */
class HeaderView extends UiView
{
    /**
     * Render content
     */
    protected function renderContent()
    {
        $themeName       = FrontUtil::getThemeName();
        $file            = UsniAdaptor::getAlias('@themes/' . $themeName . '/views/common/_header') . '.php';
        $headerContent   = $this->getView()->renderPhpFile($file, $this->getParams());
        return $headerContent;
    }
    
    /**
     * Get params
     * @return array
     */
    protected function getParams()
    {
        return ['currency' => $this->renderCurrencyView(),
                'store'    => $this->renderStoreView(),
                'language' => $this->renderLanguageView(),
                'topNavLinks' => $this->renderTopNavLinks(),
                'logo'     => $this->renderLogoView(),
                'shoppingCart' => $this->renderShoppingCartHeaderView(),
                'search'   => $this->renderSearchNavView()
                ];
    }


    /**
     * Render shopping cart header view
     * @return string
     */
    protected function renderShoppingCartHeaderView()
    {
        return FrontUtil::renderSubView(ShoppingCartHeaderView::className());
    }
    
    /**
     * Render search nav view
     * @return string
     */
    protected function renderSearchNavView()
    {
        return FrontUtil::renderSubView(SearchNavView::className());
    }
    
    /**
     * Render language view
     * @return string
     */
    protected function renderLanguageView()
    {
        return ApplicationUtil::getMultilanguageDropDown(LanguageSelectionView::className());
    }
    
    /**
     * Render logo view
     * @return string
     */
    protected function renderLogoView()
    {
        return FrontUtil::renderSubView(LogoView::className());
    }
    
    /**
     * Render top nav links
     * @return string
     */
    protected function renderTopNavLinks()
    {
        $topNavViewClass = UsniAdaptor::app()->viewHelper->getInstance('topNavView');
        return FrontUtil::renderSubView($topNavViewClass);
    }
    
    /**
     * Render currency view
     * @return string
     */
    protected function renderCurrencyView()
    {
        return FrontUtil::renderSubView(CurrencyView::className());
    }
    
    /**
     * Render store view
     * @return string
     */
    protected function renderStoreView()
    {
        return FrontUtil::renderSubView(StoreView::className());
    }
}