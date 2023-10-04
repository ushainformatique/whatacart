<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\bootstrap;

/**
 * Override bootstrap ActiveForm class for changes specific to bulk edit.
 * 
 * @package usni\library\bootstrap
 */
class BulkEditActiveForm extends ActiveForm
{
    /**
     * @inheritdoc
     * @see fieldConfig
     */
    public $fieldClass = 'usni\library\bootstrap\BulkEditActiveField';
    
    /**
     * @inheritdoc
     */
    public $fieldConfig = [ 'template' => "{checkbox}{beginLabel}{labelTitle}{endLabel}{beginWrapper}{input}{error}{endWrapper}",
                            'inputOptions' => ['disabled' => 'disabled', 'class' => 'form-control'],
                            'horizontalCssClasses' => [
                                                        'label'     => 'col-sm-1',
                                                        'offset'    => '',
                                                        'wrapper'   => 'col-sm-10',
                                                        'error'     => '',
                                                        'hint'      => '',
                                                   ]];
}