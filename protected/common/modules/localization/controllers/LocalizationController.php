<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace common\modules\localization\controllers;

use usni\library\components\UiAdminController;
use usni\UsniAdaptor;
/**
 * LocalizationController is base controller class for all localization controllers.
 * @package common\modules\localization\controllers
 */
class LocalizationController extends UiAdminController
{
    /**
     * @inheritdoc
     */
    public function actionIndex()
    {
        $this->redirect(UsniAdaptor::createUrl('/localization/' . $this->module->id . '/' . $this->id . '/manage'));
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
        $modelClass = strtolower(UsniAdaptor::getObjectClassName($this->resolveModelClassName()));
        return '/' . "localization/$modelClass/" . $this->id . '/manage';
    }
}
?>