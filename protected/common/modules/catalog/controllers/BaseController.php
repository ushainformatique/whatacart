<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace common\modules\catalog\controllers;

use usni\library\components\UiAdminController;
use usni\UsniAdaptor;
/**
 * BaseController is base controller class for all catalog controllers.
 * 
 * @package common\modules\catalog\controllers
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
        return ['/catalog/' . $this->module->id . '/' . $this->id . '/manage'];
    }
    
    /**
     * @inheritdoc
     */
    protected function resolveDefaultRedirectUrl()
    {
        return '/catalog/' . $this->module->id . '/' . $this->id . '/manage';
    }
}
?>