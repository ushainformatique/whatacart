<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace frontend\views\common;

use usni\UsniAdaptor;
/**
 * LanguageSelectionView class file.
 * @package frontend\views\commmon
 */
class LanguageSelectionView extends \common\modules\localization\modules\language\views\LanguageSelectionView
{ 
    /**
     * @inheritdoc
     */
    public function getActionUrl()
    {
        return UsniAdaptor::createUrl('customer/site/change-language');
    }
}