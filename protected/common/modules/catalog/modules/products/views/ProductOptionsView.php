<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace products\views;

use usni\library\views\UiView;
use products\views\AssignProductOptionsListView;
use usni\library\components\UiHtml;
/**
 * ProductOptionsView class file.
 *
 * @package products\views
 */
class ProductOptionsView extends UiView
{
    public $model;
    
    /**
     * @inheritdoc
     */
    protected function renderContent()
    {
        $listView   = new AssignProductOptionsListView(['product' => $this->model, 'shouldRenderActionColumn' => false]);
        $listViewContent = UiHtml::tag('div', $listView->render(), ['id' => "product-option-values-container"]);
        return $listViewContent;
    }
}
?>