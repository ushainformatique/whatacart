<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace customer\views\front;

use usni\UsniAdaptor;
/**
 * RegistrationView class file.
 *
 * @package customer\views\front
 */
class RegistrationView extends AccountPageView
{
    /**
     * @inheritdoc
     */
    protected function renderInnerContent()
    {
        $viewHelper         = UsniAdaptor::app()->getModule('customer')->viewHelper;
        $profileEditView    = $viewHelper->getInstance('profileEditView', ['model' => $this->model]);
        return $profileEditView->render();        
    }
    
    /**
     * @inheritdoc
     */
    protected function renderLeftColumn()
    {
        if($this->model->scenario == 'editprofile')
        {
            return parent::renderLeftColumn();
        }
        return null;
    }
}
