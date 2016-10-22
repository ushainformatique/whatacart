<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace frontend\components;

use usni\library\components\BaseViewHelper;
/**
 * FrontViewHelper class file.
 * @package frontend\components
 */
class FrontViewHelper extends BaseViewHelper
{
    /**
     * Nav bar view
     * @var string 
     */
    public $navBarView      = 'frontend\views\common\NavbarView';
    
    /**
     * Top nav
     * @var string 
     */
    public $topNavView      = 'frontend\views\common\TopNavLinksView';

    /**
     * Page breadcrumb
     * @var string 
     */
    public $breadcrumbView  = 'frontend\modules\site\views\BreadcrumbView';

    /**
     * Global menu view
     * @var string 
     */
    public $globalMenuView    = 'frontend\views\common\GlobalMenuView';
    
    /**
     * Header view
     * @var string 
     */
    public $headerView    = 'frontend\views\common\HeaderView';
    
    /**
     * Footer view
     * @var string 
     */
    public $footerView    = 'frontend\views\common\FooterView';
}
?>