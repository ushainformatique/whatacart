<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace customer\views\front;

use usni\UsniAdaptor;
use customer\views\BaseChangePasswordFormView;
use frontend\utils\FrontUtil;
/**
 * ChangePasswordFormView class file.
 *
 * @package customer\views
 */
class ChangePasswordFormView extends BaseChangePasswordFormView
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
    protected function renderTitle()
    {
        return UsniAdaptor::t('users', 'Change Password');
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
    
    /**
     * Get button url
     * @return string
     */
    protected function getButtonUrl()
    {
        return 'customer/site/my-account';
    }
}
?>