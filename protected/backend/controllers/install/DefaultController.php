<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace backend\controllers\install;

use usni\library\utils\CookieUtil;
use usni\UsniAdaptor;
/**
 * DefaultController class file.
 * 
 * @package backend\controllers\install
 */
class DefaultController extends \usni\library\modules\install\controllers\DefaultController
{
    /**
     * View file for the welcome screen
     * @var string
     */
    public $welcomeViewFile = '//install/welcome';
    
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->getView()->title     = UsniAdaptor::t('application', 'WhatACart Installation');
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
}