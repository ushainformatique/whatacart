<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\traits;

/**
 * Implement common functions related to web application
 * 
 * @package common\traits
 */
trait WebApplicationTrait
{
    /**
     * Sets database config.
     * 
     * @return void
     */
    public function setDatabaseConfig()
    {
        if($this->installed)
        {
            $this->db->enableSchemaCache    = $this->configManager->getValue('application', 'enableSchemaCache');
            $this->db->schemaCacheDuration  = $this->configManager->getValue('application', 'schemaCachingDuration');
        }
    }
    
    /**
     * Sets date time config.
     * @return void
     */
    public function setDateTimeConfig()
    {
        if($this->installed)
        {
            $appTimezone = $this->configManager->getValue('application', 'timezone');
            if($appTimezone == null)
            {
                date_default_timezone_set('Asia/Kolkata');
            }
            else
            {
                date_default_timezone_set($appTimezone);
            }
        }
    }
}
