<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace products\views;

use usni\library\views\UiView;
use usni\library\components\UiHtml;
/**
 * ProductAttributesView class file.
 * @package products\views
 */
class ProductAttributesView extends UiView
{
    /**
     * Product id associated with the view.
     * @var Product 
     */
    public $productId;
    
    /**
     * @inheritdoc
     */
    protected function renderContent()
    {
        $view           = new AssignProductAttributeView(['productId' => $this->productId]);
        $viewContent    = UiHtml::tag('div', $view->render(), ['id' => "product-attribute-values-container"]);
        return $viewContent;
    }
}
?>