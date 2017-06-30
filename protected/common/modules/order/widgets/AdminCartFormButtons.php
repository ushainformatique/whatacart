<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\order\widgets;

use usni\UsniAdaptor;
use usni\library\utils\Html;
/**
 * AdminCartFormButtons renders form buttons in the admin panel for view cart screen.
 *
 * @package common\modules\order\widgets
 */
class AdminCartFormButtons extends \usni\library\bootstrap\FormButtons
{
    /**
     * inheritdoc
     */
    public $layout = "<div class='form-actions text-right'>{submit}\n{cancel}\n{addproduct}</div>";
    
    /**
     * inheritdoc
     */
    public function renderSection($name)
    {
        switch ($name) 
        {
            case '{addproduct}':
                return $this->renderAddProductButton();
            default:
                return parent::renderSection($name);
        }
    }
    
    /**
     * Renders edit cart button
     * @return string
     */
    public function renderAddProductButton()
    {
        $label = UsniAdaptor::t('products', 'Add Product');
        return Html::a($label, '#', ['class' => 'btn btn-info', 'id' => 'addproduct-button']);
    }
}
