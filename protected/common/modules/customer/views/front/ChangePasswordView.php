<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace customer\views\front;

use usni\UsniAdaptor;
/**
 * ChangePasswordView class file.
 *
 * @package customer\views\front
 */
class ChangePasswordView extends AccountPageView
{
    /**
     * @inheritdoc
     */
    protected function renderInnerContent()
    {
        $viewHelper         = UsniAdaptor::app()->getModule('customer')->viewHelper;
        $view               = $viewHelper->getInstance('changePasswordFormView', ['model' => $this->model]);
        return $view->render();
    }
}
