<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\filters;

use usni\UsniAdaptor;
use yii\helpers\Url;

/**
 * Filter that automatically checks if the request is for maintenance and redirects appropriately
 * 
 * @package usni\library\filters
 */
class MaintenanceFilter extends \yii\base\ActionFilter
{
    /**
     * @inheritdoc
     */
	public function beforeAction($action)
	{
        $currentUrl   = Url::to('');
        $isInstalled  = UsniAdaptor::app()->installed;
        if($isInstalled)
        {
            if($this->isMaintenanceMode() === true && strpos($currentUrl, 'maintenance') === false)
            {
                if(UsniAdaptor::app()->maintenanceManager->checkAccess() === false)
                {
                    UsniAdaptor::app()->user->logout(false);
                    UsniAdaptor::app()->cache->flush();
                    $url = UsniAdaptor::createUrl(UsniAdaptor::app()->maintenanceManager->url);
                    return $this->owner->redirect($url);
                }
            }
        }
        return true;
	}
    
    /**
     * Checks if site is in maintenance mode.
     * @return boolean
     */
    public function isMaintenanceMode()
    {
        $siteMaintenance = UsniAdaptor::app()->configManager->getValue('application', 'siteMaintenance');
        if ($siteMaintenance == null)
        {
            return false;
        }
        else
        {
            if (intval($siteMaintenance) == 0)
            {
                return false;
            }
            else
            {
                return true;
            }
        }
    }
}