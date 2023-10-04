<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\modules\home\controllers;

use usni\UsniAdaptor;
/**
 * DefaultController for the module.
 * 
 * @package usni\library\modules\home\controllers
 */
class DefaultController extends \usni\library\web\Controller
{
    /**
     * Renders to Login or dashboard.
     * @return void
     */
    public function actionIndex()
    {
        if (UsniAdaptor::app()->user->getIsGuest())
        {
            UsniAdaptor::app()->user->loginRequired();
        }
        else
        {
            $this->redirect(UsniAdaptor::createUrl('/home/default/dashboard'));
        }
    }
}