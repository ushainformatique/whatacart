<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\widgets;

use yii\base\Model;
use usni\UsniAdaptor;
/**
 * TabbedActiveFormAlert renders an error container if the tabbed form has errors
 *
 * @package usni\library\widgets
 */
class TabbedActiveFormAlert extends \yii\bootstrap\Widget
{
    /**
     * Form model
     * @var Model 
     */
    public $model;
    
    /**
     * @var array of errors in the model/models 
     */
    public $errors;
    
    /**
     * inheritdoc
     */
    public function run()
    {
        if(empty($this->errors))
        {
            $doesErrorExists = $this->model->hasErrors();
        }
        else
        {
            $doesErrorExists = true;
        }
        if($doesErrorExists)
        {
            $style = "display:block";
        }
        else
        {
            $style = "display:none";
        }
        echo '<div class="alert alert-danger" id="formErrorsInfo" style="' . $style . '">' . 
                    UsniAdaptor::t('application', 'Please check the form carefully for the errors in the individual tabs.') . '</div>';
    }
}
