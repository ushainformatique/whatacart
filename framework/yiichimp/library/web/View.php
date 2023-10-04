<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\web;

/**
 * Extends the base view providing methods to render various sections on the page.
 * 
 * @package usni\library\web
 */
class View extends \yii\web\View
{
    /**
     * Css class applied to the body tag
     * @var string 
     */
    public $bodyClass;
    
    /**
     * Renders left column
     * @return string
     */
    public function renderLeftColumn()
    {
        return null;
    }
    
    /**
     * Get left column content
     * @return string
     */
    public function getLeftColumnContent()
    {
        return null;
    }

    /**
     * Get right column content
     * @return string
     */
    public function getRightColumnContent()
    {
        return null;
    }
    
    /**
     * Renders right column
     * @return string
     */
    public function renderRightColumn()
    {
        return null;
    }
    
    /**
     * Render breadcrumb
     * @return string
     */
    public function renderBreadcrumb()
    {
        return null;
    }
}
