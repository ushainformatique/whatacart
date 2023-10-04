<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\web;

use usni\UsniAdaptor;
use yii\base\Behavior;
use yii\helpers\Url;
use yii\base\Event;

/**
 * BeforeRequestBehavior class file.
 * The methods would be used when beforeRequest event is raised by the application. It should be included in backend config file.
 * 
 * @package usni\library\web
 */
class BeforeRequestBehavior extends Behavior
{
    /**
     * Attach events with this behavior.
     * @return array
     */
    public function events()
    {
        return [Application::EVENT_BEFORE_REQUEST => [$this, 'handleOnBeginRequest']];
    }
    
    /**
     * Event handler before request is processed.
     * 
     * @param Event $event
     * @return void
     */
    public function handleOnBeginRequest($event)
    {
        $this->isRebuildInProgress();
        $this->checkInstallAndRedirect();
    }

    /**
     * Check if rebuild is in progress
     */
    protected function isRebuildInProgress()
    {
        $currentUrl   = Url::to('');
        $homeUrl      = Url::home();
        $rebuildUrl = $this->getRebuildUrl();
        if(UsniAdaptor::app()->installed === true
                && UsniAdaptor::app()->isRebuildInProgress() === true
                    && strpos($currentUrl, $rebuildUrl) === false)
        {
            if(strpos($currentUrl, 'backend') === false)
            {
                $url = UsniAdaptor::app()->getRequest()->baseUrl . '/backend/index.php';
            }
            else
            {
                $url = UsniAdaptor::app()->getRequest()->baseUrl . '/index.php';
            }
            if(UsniAdaptor::app()->urlManager->enablePrettyUrl === true)
            {
                $url .= '/' . $rebuildUrl;
            }
            else
            {
                $url .= '?' . UsniAdaptor::app()->urlManager->routeVar . '=' . $rebuildUrl;
            }
            UsniAdaptor::app()->getResponse()->redirect($url)->send();
            return;
        }
        elseif(UsniAdaptor::app()->installed === true
                && UsniAdaptor::app()->isRebuildInProgress() === false
                    && strpos($currentUrl, $rebuildUrl) > 0)
        {
            UsniAdaptor::app()->getResponse()->redirect($homeUrl)->send();
            return;
        }
    }

    /**
     * Checks if application is installed. If application is not installed and user tries to access
     * any other page, would be redirected to install index page.
     * @return void
     */
    protected function checkInstallAndRedirect()
    {
        $url        = Url::to('');
        $baseUrl    = Url::base(true);
        if(UsniAdaptor::app()->isInstalled() === false)
        {
            if(strpos($url, 'backend') === false)
            {
                $url = UsniAdaptor::app()->getRequest()->baseUrl . '/backend/index.php';
                UsniAdaptor::app()->getResponse()->redirect($url)->send();
                UsniAdaptor::app()->end(0);
            }
            if(strpos($url, 'install') === false)
            {
                if(UsniAdaptor::app()->urlManager->enablePrettyUrl === true)
                {
                    $url = $baseUrl . '/install/default';
                }
                else
                {
                    $url = $baseUrl . '?' . UsniAdaptor::app()->getUrlManager()->routeParam . '=install/default';
                }
                UsniAdaptor::app()->getResponse()->redirect($url)->send();
                UsniAdaptor::app()->end(0);
            }
        }
    }
    
    /**
     * Get rebuild url.
     * @return string
     */
    protected function getRebuildUrl()
    {
        return 'service/default/rebuild';
    }
}