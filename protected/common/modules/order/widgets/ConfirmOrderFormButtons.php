<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\order\widgets;

use usni\UsniAdaptor;
use usni\library\utils\Html;
/**
 * ConfirmOrderFormButtons renders form buttons in the front end for confirm order screen.
 *
 * @package common\modules\order\widgets
 */
class ConfirmOrderFormButtons extends \usni\library\bootstrap\FormButtons
{
    /**
     * inheritdoc
     */
    public $layout = "<div class='form-actions text-right'>{submit}\n{cancel}\n{editcart}</div>";
    
    /**
     * @var string url for edit cart 
     */
    public $editCartUrl;
    
    /**
     * @var string label for edit cart 
     */
    public $editCartLabel;
    
    /**
     * Html options for the edit button
     * @var array 
     */
    public $editButtonOptions = ['id' => 'edit-button', 'class' => 'btn btn-default'];
    
    /**
     * inheritdoc
     */
    public function renderSection($name)
    {
        switch ($name) 
        {
            case '{editcart}':
                return $this->renderEditCartButton();
            default:
                return parent::renderSection($name);
        }
    }
    
    /**
     * Renders edit cart button
     * @return string
     */
    public function renderEditCartButton()
    {
        if($this->editCartLabel == null)
        {
            $this->editCartLabel = UsniAdaptor::t('cart', 'Edit Cart');
        }
        return Html::a($this->editCartLabel, $this->editCartUrl, $this->editButtonOptions);
    }
}
