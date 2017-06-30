<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace frontend\widgets;

/**
 * FormButtons renders form buttons for the front end.
 *
 * @package frontend\widgets
 */
class FormButtons extends \usni\library\bootstrap\FormButtons
{
    /**
     * inheritdoc
     */
    public $layout = "<div class='row'><div class='form-actions text-right'>{submit}\n{cancel}</div></div>";
    /**
     * inheritdoc
     */
    public $submitButtonOptions = ['class' => 'btn btn-success', 'id' => 'save'];
}
