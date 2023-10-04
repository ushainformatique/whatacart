<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\modules\auth\controllers;

use usni\UsniAdaptor;
/**
 * DefaultController class file.
 *
 * @package usni\library\modules\auth\controllers
 */
class DefaultController extends \usni\library\web\Controller
{
    /**
     * Redirects to group index. Index action will be invoked if there is no any action found in url. eg: '/index.php/auth'
     * @return void
     */
    public function actionIndex()
    {
        $this->redirect(UsniAdaptor::createUrl('auth/group/index'));
    }
}
