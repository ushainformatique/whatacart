<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\web\actions;

use usni\library\dto\FormDTO;
/**
 * EditAction class file. This would act as base class for CreateAction and UpdateAction.
 *
 * @package usni\library\web\actions
 */
abstract class EditAction extends Action
{
    /**
     * @var string class name of the [[FormDTO]] which will be used in this action.
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
            $this->formDTOClass = FormDTO::className();
        }
    }
}