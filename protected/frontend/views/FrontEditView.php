<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace frontend\views;

use usni\library\extensions\bootstrap\views\UiBootstrapEditView;
use frontend\utils\FrontUtil;
/**
 * FrontEditView class file.
 *
 * @package frontend\views
 */
abstract class FrontEditView extends UiBootstrapEditView
{
    /**
     * @inheritdoc
     */
    public function resolveFormViewPath()
    {
        $themeName = $this->getTheme();
        return "@themes/$themeName/views/_form";
    }
    
    /**
     * Get theme.
     * @return string
     */
    protected function getTheme()
    {
        return FrontUtil::getThemeName();
    }
    
    /**
     * @inheritdoc
     */
    protected function getHorizontalCssClasses()
    {
        $cssClasses = parent::getHorizontalCssClasses();
        $cssClasses['wrapper'] = 'col-sm-10';
        $cssClasses['label'] = 'col-sm-2';
        return $cssClasses;
    }
    
    /**
     * @inheritdoc
     */
    protected function getDefaultButtonOptions()
    {
        $options = parent::getDefaultButtonOptions();
        $options['submit'] = array('class' => 'btn btn-success');
        return $options;
    }
}