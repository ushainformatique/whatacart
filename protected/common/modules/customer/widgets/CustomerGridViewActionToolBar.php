<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace customer\widgets;

use usni\library\components\UiHtml;
use customer\models\CustomerBulkEditForm;
use usni\library\extensions\bootstrap\widgets\UiGridViewActionToolBar;

/**
 * ButtonToolbar renders a button toolbar bootstrap component.
 *
 * For example,
 *
 * ```php
 * // a button toolbar group with items configuration
 * echo UiGridViewActionToolBar::widget([
 *     'model'         => $this->model,
 *     'controller'    => $this->getController(),
 *     'options'       => ['class' => 'action-toolbar'],
 *     'grid'          => $this
 * ]);
 * ```
 * @see usni\library\components\UiGridView
 * @see http://getbootstrap.com/components/#btn-groups-toolbar
 * @see http://getbootstrap.com/components/#btn-groups
 */
class CustomerGridViewActionToolBar extends UiGridViewActionToolBar
{
     /**
     * Renders search form
     * @return string
     */
    protected function renderBulkEditForm()
    {
        if($this->showBulkEdit)
        {
            $bulkEditViewClassName    = $this->getBulkEditViewClassName();
            $formContent              = null;
            if (@class_exists($bulkEditViewClassName))
            {
                $model          = new CustomerBulkEditForm();
                $bulkEditView   = new $bulkEditViewClassName($model, $this->grid->id, $this->grid->pjaxContainerId);
                $formContent    = UiHtml::tag('div', $bulkEditView->render(), ['class' => 'bulk-edit-form', 'style' => 'display:none']);
            }
            return $formContent;
        }
        return null;
    }
}
