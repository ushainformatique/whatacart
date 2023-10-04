<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\web;

use usni\UsniAdaptor;
use usni\library\utils\RequestUtil;
use usni\library\utils\CacheUtil;

/**
 * Application extends base application by providing functions required for the application.
 * 
 * @package usni\library\web
 */
class Application extends \yii\web\Application
{
    use \usni\library\traits\ApplicationTrait;
    
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->setCacheComponent();
        $this->checkRebuildModuleMetadataRequest();
        $this->checkClearCacheRequest();
        $this->moduleManager->bootstrap();
        if(UsniAdaptor::app()->isInstalled())
        {
            $this->setNonStrictSqlMode();
        }
    }
    
    /**
     * Check if rebuild module metadata request is there.
     */
    public function checkRebuildModuleMetadataRequest()
    {
        $rebuildData = $this->request->get('rebuildModuleMetadata', 'false');
        if($rebuildData == 'true')
        {
            CacheUtil::delete('moduleMetadata');
            $this->moduleManager->buildModuleConfig();
        }
    }
    
    /**
     * Check if request for clear cache is there. if yes then flush cache.
     */
    public function checkClearCacheRequest()
    {
        $clearCache = $this->request->get('clearCache', 'false');
        if($clearCache === 'true' && $this->isInstalled())
        {
            //Clear the configuration so that fresh values are loaded into cache
            CacheUtil::clearCache();
        }
    }
    
    /**
     * Returns a string that can be displayed on your Web page showing Powered-by-usni information
     * @return string a string that can be displayed on your Web page showing Powered-by-usni information
     */
    public function powered()
    {
		return UsniAdaptor::t('application','Powered by {application}.', array('application'=>'<a href="' . $this->poweredByUrl . '" rel="external">' . $this->poweredByName . '</a>'));
    }

    /**
     * Checks if rebuild is in progress.
     * @return bool
     */
    public function isRebuildInProgress()
    {
        $isRebuild = file_exists(APPLICATION_PATH . '/protected/backend/runtime/rebuildstate.bin');
        return (bool)$isRebuild;
    }

    /**
     * Get front url. This would be required where in back end we need front url
     * @return string
     */
    public function getFrontUrl()
    {
        return RequestUtil::getDomainUrl();
    }

    /**
     * Set non strict sql mode
     */
    public function setNonStrictSqlMode()
    {
        UsniAdaptor::db()->createCommand("SET SESSION sql_mode = ''")->execute();
    }
}