<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace customer\views\front;

use usni\UsniAdaptor;
use frontend\utils\FrontUtil;
use customer\views\ProfileEditView;
use usni\library\utils\ButtonsUtil;
/**
 * CustomerProfileEditView class file.
 * @package customer\views\front
 */
class CustomerProfileEditView extends ProfileEditView
{
    /**
     * @inheritdoc
     */
    public function getFormBuilderMetadata()
    {
        $metadata = parent::getFormBuilderMetadata();
        $metadata['buttons'] = ['continue' => ButtonsUtil::getSubmitButton(UsniAdaptor::t('application', 'Continue'))];
        return $metadata;
    }
    
    /**
     * @inheritdoc
     */
    protected function renderTitle()
    {
        $user               = UsniAdaptor::app()->user->getUserModel();
        if($user == null)
        {
            $title = UsniAdaptor::t('customer', 'Register Account');
        }
        else
        {
            $title = UsniAdaptor::t('users', 'Edit Profile');
        }
        return $title;
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
    public function resolveFormViewPath()
    {
        $themeName = $this->getTheme();
        return "@themes/$themeName/views/_form";
    }
    
    /**
     * @inheritdoc
     */
    protected function renderEditModeBrowseView()
    {
        return null;
    }
    
    /**
     * @inheritdoc
     */
    protected function getCustomerEditView()
    {
        $viewHelper = UsniAdaptor::app()->getModule('customer')->viewHelper;
        return $viewHelper->customerEditView;
    }
    
    /**
     * @inheritdoc
     */
    protected function getButtonsWrapper()
    {
        return "<div class='form-actions text-right'>{buttons}</div>";
    }
    
    /**
     * @inheritdoc
     */
    protected function getPersonEditView()
    {
        $viewHelper = UsniAdaptor::app()->getModule('customer')->viewHelper;
        return $viewHelper->personEditView;
    }
    
    /**
     * @inheritdoc
     */
    protected function getAddressEditView()
    {
        $viewHelper = UsniAdaptor::app()->getModule('customer')->viewHelper;
        return $viewHelper->addressEditView;
    }
}
?>