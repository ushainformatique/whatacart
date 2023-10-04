<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\web;

use yii\base\Behavior;
use usni\library\web\User;
use yii\web\UserEvent;
use usni\UsniAdaptor;
/**
 * UserBehavior extends the functionality related to User component. It would also handle
 * afterLogin event raised by the application.
 * 
 * @package usni\library\modules\users\web
 */
class UserBehavior extends Behavior
{
    /**
     * Attach events with this behavior.
     * @return array
     */
    public function events()
    {
        return array(User::EVENT_AFTER_LOGIN => array($this, 'processAfterLogin'));
    }

    /**
     * Called after successfully logging into the system.
     * @param UserEvent $event
     */
    public function processAfterLogin(UserEvent $event)
    {
        $user       = $event->identity;
        $lastLogin  = date('Y-m-d H:i:s');
        $loginIp    = UsniAdaptor::app()->getRequest()->getUserIP();
        $modelClass = get_class($user);
        $table      = $modelClass::tableName();
        $sql        = "UPDATE " . $table . " SET last_login = :ll, login_ip = :ip WHERE id = :id";
        UsniAdaptor::db()->createCommand($sql, [':ll' => $lastLogin, ':ip' => $loginIp, ':id' => $user->id])->execute();
    }
}