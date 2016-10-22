<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace backend\controllers\install;

use usni\library\modules\install\controllers\DefaultController;
use backend\views\install\WelcomeView;
use usni\library\utils\CookieUtil;
use backend\views\install\InstallSettingsView;
use backend\views\install\InstallFinishView;
use backend\views\AdminOneColumnView;
/**
 * ExtendedDefaultController class file.
 * 
 * @package backend\controllers\install
 */
class ExtendedDefaultController extends DefaultController
{
    /**
     * @inheritdoc
     */
    protected function getInstallWelcomeView()
    {
        return WelcomeView::className();
    }
    
    /**
     * @inheritdoc
     */
    public function actionIndex()
    {
        CookieUtil::remove('whatacartAdminLanguage');
        CookieUtil::remove('whatacartAdminContentLanguage');
        CookieUtil::remove('whatacartAdminCurrency');
        CookieUtil::remove('whatacartAdminStore');
        CookieUtil::remove('whatacartFrontContentLanguage');
        CookieUtil::remove('whatacartFrontCurrency');
        CookieUtil::remove('whatacartFrontStore');
        return parent::actionIndex();
    }
    
    /**
     * @inheritdoc
     */
    protected function getInstallSettingsView()
    {
        return InstallSettingsView::className();
    }
    
    /**
     * @inheritdoc
     */
    protected function getInstallFinishView()
    {
        return InstallFinishView::className();
    }
    
    /**
     * @inheritdoc
     */
    protected function resolveColumnViewClassName()
    {
        return AdminOneColumnView::className();
    }
}