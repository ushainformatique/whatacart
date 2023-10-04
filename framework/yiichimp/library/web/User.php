<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\web;

use usni\UsniAdaptor;
/**
 * Extends base component to override the changes specific to framework.
 *
 * @package usni\library\web
 */
class User extends \yii\web\User
{
    /**
     * @inheritdoc
     */
    protected function getAccessChecker()
    {
        return $this->accessChecker !== null ? $this->accessChecker : UsniAdaptor::app()->authorizationManager;
    }
}
