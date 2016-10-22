<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace frontend\components;

use usni\UsniAdaptor;
use usni\library\utils\ArrayUtil;
/**
 * FrontColumnView class file
 *
 * @package frontend\components
 */
class FrontColumnView extends \yii\base\Component
{
    /**
     * Renders navigation bar.
     * @return string
     */
    public function renderNavBar()
    {
        $topnavView = UsniAdaptor::app()->viewHelper->getInstance('navBarView');
        if($topnavView != null)
        {
            return $topnavView->render();
        }
        return null;
    }
    
    /**
     * Renders footer.
     * @return string
     */
    public function renderFooter()
    {
        $footerView = UsniAdaptor::app()->viewHelper->getInstance('footerView');
        if($footerView != null)
        {
            return $footerView->render();
        }
        return null;
    }

    /**
     * Renders header.
     * @return string
     */
    public function renderHeader()
    {
        $headerView = UsniAdaptor::app()->viewHelper->getInstance('headerView');
        if($headerView != null)
        {
            return $headerView->render();
        }
        return null;
    }
    
    /**
     * Render breadcrumb
     * @param View $view
     * @return string
     */
    public function renderBreadcrumb($view)
    {
        $content = null;
        //Set the breadcrumb if there
        $breadcrumbs = ArrayUtil::getValue($view->params, 'breadcrumbs');
        if(!empty($breadcrumbs))
        {
            $breadcrumbView = UsniAdaptor::app()->viewHelper->getInstance('breadcrumbView');
            $content        = $breadcrumbView->render();
        }
        return $content;
    }
}
?>