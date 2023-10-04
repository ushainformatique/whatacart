<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\bootstrap;

use usni\UsniAdaptor;
use usni\library\utils\Html;

/**
 * BulkEditFormButton renders form button on grid form.
 *
 * @package usni\library\bootstrap
 */
class BulkEditFormButton extends \yii\bootstrap\Widget
{
    /**
     * Layout under which buttons would be rendered
     * @var string 
     */
    public $layout = '<div class="form-actions text-right">{content}</div>';
    
    /**
     * Html options for the submit button
     * @var array 
     */
    public $submitButtonOptions = ['class' => 'btn btn-primary grid-bulk-edit-btn', 'id' => 'save'];
    
    /**
     * Label for the submit button
     * @var string 
     */
    public $submitButtonLabel;
    
    /**
     * inheritdoc
     */
    public function run()
    {
        if($this->submitButtonLabel == null)
        {
            $this->submitButtonLabel = UsniAdaptor::t('application', 'Submit');
        }
        $content = Html::submitButton($this->submitButtonLabel, $this->submitButtonOptions);
        return str_replace('{content}', $content, $this->layout);
    }
}
