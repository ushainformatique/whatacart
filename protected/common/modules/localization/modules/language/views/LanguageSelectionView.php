<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace common\modules\localization\modules\language\views;

use usni\UsniAdaptor;
/**
 * LanguageSelectionView class file.
 * 
 * @package common\modules\localization\modules\language\views
 */
class LanguageSelectionView extends \usni\library\views\LanguageSelectionView
{ 
    /**
     * @inheritdoc
     */
    public function getActionUrl()
    {
        return UsniAdaptor::createUrl('users/default/change-language');
    }
    
     /**
     * @inheritdoc
     */
    protected function wrapContent($content)
    {
        return '<li class="dropdown">' . $content . '</li>';
    }
    
    /**
     * @inheritdoc
     */
    protected function getHeaderLinkOptions()
    {
        return array('data-toggle' => 'dropdown', 'class' => 'dropdown-toggle');
    }
}