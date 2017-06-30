<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace frontend\widgets;

/**
 * Override framework ActiveForm class for changes specific to frontend.
 * 
 * @package frontend\widgets
 */
class ActiveForm extends \usni\library\bootstrap\ActiveForm
{
    /**
     * @inheritdoc
     */
    public $fieldConfig = [ 'template' => "{beginLabel}{labelTitle}{endLabel}{beginWrapper}{input}{error}{endWrapper}",
                            'horizontalCssClasses' => [
                                                        'label'     => 'col-sm-2',
                                                        'offset'    => '',
                                                        'wrapper'   => 'col-sm-10',
                                                        'error'     => '',
                                                        'hint'      => '',
                                                   ]];
    /**
     * @inheritdoc
     */
    public $decoratorView = '//layouts/edit.php';
}