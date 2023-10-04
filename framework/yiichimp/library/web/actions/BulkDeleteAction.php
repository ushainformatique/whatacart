<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\web\actions;

use usni\library\dto\GridViewDTO;
use usni\UsniAdaptor;
use usni\library\utils\CacheUtil;
/**
 * BulkDeleteAction class file. This would act as standalone action class for bulk delete.
 *
 * @package usni\library\web\actions
 */
class BulkDeleteAction extends Action
{
    /**
     * @var string class name of the [[BulkEditFormDTO]] which will be used in this action.
     * This property must be set.
     */
    public $dtoClass;
    
    /**
     * inheritdoc
     */
    public function init()
    {
        if($this->dtoClass == null)
        {
            $this->dtoClass = GridViewDTO::className();
        }
    }
    
    /**
     * Runs the action
     * @return string
     */
    public function run()
    {
        if(UsniAdaptor::app()->request->isAjax && isset($_GET['id']))
        {
            /* @var $gridViewDTO \usni\library\dto\GridViewDTO */
            $gridViewDTO    = new $this->dtoClass();
            $gridViewDTO->setModelClass($this->modelClass);
            $gridViewDTO->setSelectedIdsForBulkDelete($_GET['id']);
            //Derive manager and call the function
            $manager        = $this->getManagerInstance();
            $manager->processBulkDelete($gridViewDTO);
            //Clear cache after model delete.
            CacheUtil::clearCache();
        }
    }
}