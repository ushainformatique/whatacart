<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace taxes\controllers;

use usni\library\components\UiAdminController;
use usni\UsniAdaptor;
/**
 * BaseController class file
 * @package taxes\controllers
 */
class BaseController extends UiAdminController
{
    /**
     * @inheritdoc
     */
    public function actionIndex()
    {
        $this->redirect(UsniAdaptor::createUrl($this->resolveDefaultRedirectUrl()));
    }
    
    /**
     * Get breadcrumb manage url.
     * @return array
     */
    protected function getBreadCrumbManageUrl()
    {
        return ['/localization/' . $this->module->id . '/' . $this->id . '/manage'];
    }
    
    /**
     * @inheritdoc
     */
    protected function resolveDefaultRedirectUrl()
    {
        return '/localization/' . $this->module->id . '/' . $this->id . '/manage';
    }
}
?>