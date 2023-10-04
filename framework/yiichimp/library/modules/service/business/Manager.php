<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\modules\service\business;

use usni\library\modules\auth\business\AuthManager;
use usni\library\modules\install\components\ApplicationRequirementChecker;
/**
 * Manager class file.
 * 
 * @package usni\library\modules\service\business
 */
class Manager extends \usni\library\business\Manager
{
    /**
     * Process load modules permissions.
     * @return boolean
     */
    public function processLoadModulesPermissions()
    {
        $authManager    = new AuthManager();
        ini_set('max_execution_time', 180);
        if($authManager->addModulesPermissions())
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    
    /**
     * Process check system.
     * @return array
     */
    public function processCheckSystem()
    {
        $requirementsChecker = new ApplicationRequirementChecker();
        $requirements        = $requirementsChecker->getRequirements();
        return $requirementsChecker->checkYii()->check($requirements)->getResult();
    }
}
