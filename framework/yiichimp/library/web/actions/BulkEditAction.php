<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\web\actions;

use usni\library\dto\BulkEditFormDTO;
use usni\UsniAdaptor;
/**
 * BulkEditAction class file. This would act as standalone action class for bulk edit.
 *
 * @package usni\library\web\actions
 */
class BulkEditAction extends Action
{
    /**
     * @var string class name of the [[BulkEditFormDTO]] which will be used in this action.
     * This property must be set.
     */
    public $formDTOClass;
    
    /**
     * inheritdoc
     */
    public function init()
    {
        if($this->formDTOClass == null)
        {
            $this->formDTOClass = BulkEditFormDTO::className();
        }
    }
    
    /**
     * Runs the action
     * @param array $selectedIds
     * @return string
     */
    public function run($selectedIds)
    {
        if(UsniAdaptor::app()->request->isAjax)
        {
            $formDTO        = new $this->formDTOClass();
            $formDTO->setModelClass($this->modelClass);
            $formDTO->setPostData(UsniAdaptor::app()->request->post());
            $formDTO->setSelectedIds($selectedIds);
            //Derive manager and call the function
            $manager        = $this->getManagerInstance();
            $manager->processBulkEdit($formDTO);
        }
    }
}