<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace products\views;

use products\views\AssignProductAttributeEditView;
use products\models\ProductAttributeEditForm;
/**
 * ManageProductAttributesView class file
 * @package products\views
 */
class ManageProductAttributesView extends \usni\library\views\UiView
{
    /**
     * Product model associated with the view.
     * @var Product 
     */
    public $product;
    
    /**
     * @inheritdoc
     */
    protected function renderContent()
    {
        $formModel              = new ProductAttributeEditForm();
        $formModel->product_id  = $this->product->id;
        $assignView             = new AssignProductAttributeEditView(['model' => $formModel]);
        return $assignView->render();
    }
}
?>