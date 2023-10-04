<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\web;

use usni\library\web\View;
use common\web\ImageBehavior;
/**
 * View object for the admin interface.
 * 
 * @package usni\library\web
 */
class AdminView extends View
{   
    /**
     * View file for side nav
     * @var string 
     */
    public $sidenavView = '@usni/library/views/_sidenav';
    
    /**
     * View file for header
     * @var string 
     */
    public $headerView = '@usni/library/views/_topnav';
    
    /**
     * View file for footer
     * @var string 
     */
    public $footerView = '@usni/library/views/_footer';
    
    /**
     * View file for breadcrumb
     * @var string 
     */
    public $breadcrumbView = '@usni/library/views/_breadcrumbs';
    
    /**
     * inheritdoc
     */
    public function behaviors()
    {
        return [
            ImageBehavior::className()
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function renderLeftColumn()
    {
        if($this->sidenavView != null)
        {
            return $this->render($this->sidenavView);
        }
        return null;
    }
    
    /**
     * @inheritdoc
     */
    public function renderBreadcrumb()
    {
        if($this->breadcrumbView != null)
        {
            return $this->render($this->breadcrumbView);
        }
        return null;
    }
    
    /**
     * Renders footer.
     * @return string
     */
    public function renderFooter()
    {
        if($this->footerView != null)
        {
            return $this->render($this->footerView);
        }
        return null;
    }

    /**
     * Renders header.
     * @return string
     */
    public function renderHeader()
    {
        if($this->headerView != null)
        {
            return $this->render($this->headerView);
        }
        return null;
    }
}