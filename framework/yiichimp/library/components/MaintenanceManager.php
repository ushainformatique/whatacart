<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\components;

use usni\UsniAdaptor;
/**
 * MaintenanceManager class file.
 * 
 * @package usni\library\components
 */
class MaintenanceManager extends \yii\base\Component
{
    /**
     * Maintenance url
     * @var string
     */
    public $url;

    /**
     * Allowed ips.
     * @var array
     */
    public $allowedIps = ['127.0.0.1', '::1'];

    /**
     * Checks if user is allowed to access site in maintenance mode.
     * @return boolean
     */
    public function checkAccess()
    {
        $userIp = UsniAdaptor::app()->getRequest()->getUserIP();
        //Check for ::1 for localhost as done earlier in UserUtil
        if(in_array($userIp, $this->allowedIps) !== false)
        {
            return true;
        }
        return false;
    }
}