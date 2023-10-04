<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\console;

use usni\UsniAdaptor;
/**
 * Extends base console application by providing functions specific to the console application.
 * 
 * @package usni\library\console
 */
class Application extends \yii\console\Application
{
    use \usni\library\traits\ApplicationTrait;
    
    /**
     * Initializes the web application.
     * @return void
     */
    public function init()
    {
        parent::init();
        $this->setCacheComponent();
        $this->moduleManager->bootstrap();
        $isAlias = UsniAdaptor::getAlias('@console', false);
        if($isAlias != false)
        {
            $this->loadAdditionalModuleConfig('@console/config/moduleconfig.php');
        }
    }
}