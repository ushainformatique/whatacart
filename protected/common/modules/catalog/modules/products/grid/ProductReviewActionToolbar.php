<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace products\grid;

use usni\library\grid\ActionToolbar;
use usni\library\utils\Html;
use usni\fontawesome\FA;
use usni\UsniAdaptor;
/**
 * ProductReviewActionToolbar class file.
 *
 * @package products\grid
 */
class ProductReviewActionToolbar extends ActionToolbar
{
    /**
     * Show bulk approve button.
     * @var boolean
     */
    public $showBulkApprove = true;
    
    /**
     * Show bulk unapprove button.
     * @var boolean
     */
    public $showBulkUnapprove = true;
    
    /**
     * Show trash button.
     * @var boolean
     */
    public $showTrash = true;
    
    /**
     * @var string permission to be checked for bulk approve
     */
    public $bulkApprovePermission;
    
    /**
     * @var string permission to be checked for delete
     */
    public $deletePermission;
    
    /**
     * inheritdoc
     */
    public function init()
    {
        parent::init();
        if($this->bulkApprovePermission == null)
        {
            $this->bulkApprovePermission = $this->permissionPrefix . '.approve';
        }
        if($this->deletePermission == null)
        {
            $this->deletePermission = $this->permissionPrefix . '.delete';
        }
    }
    
    /**
     * Layout for the action toolbar
     * @var string 
     */
    public $layout = "<div class='block'>
                        <div class='well text-center'>
                            <div class='action-toolbar btn-toolbar'>
                            {create}\n{perPage}\n{modalDetail}\n{bulkedit}\n{bulkdelete}\n{bulkapprove}\n{bulkeunapprove}\n{trash}
                            </div>
                        </div>
                        <div class='toolbar-content'>
                            {bulkeditform}
                        </div>
                      </div>";
    
    /**
     * inheritdoc
     */
    public function renderSection($name)
    {
        switch ($name) {
            case '{bulkapprove}':
                return $this->renderBulkApproveButton();
            case '{bulkeunapprove}':
                return $this->renderBulkUnapproveButton();
            case '{trash}':
                return $this->renderTrashButton();
            default:
                return parent::renderSection($name);
        }
    }
    
    /**
     * Renders bulk approve button
     * @return string
     */
    public function renderBulkApproveButton()
    {
        if($this->showBulkApprove && UsniAdaptor::app()->user->can($this->bulkApprovePermission))
        {
            $button = Html::button(FA::icon('check') . "\n" . UsniAdaptor::t('application', 'Bulk Approve'), 
                                                                                          ["id" => "action-toolbar-bulkapprove",
                                                                                          "class" => "btn btn-default bulk-approve-btn"]);
            return Html::tag('div', $button, ['class' => "btn-group"]);
        }
        return null;
    }
    
    /**
     * Renders bulk unapprove button
     * @return string
     */
    public function renderBulkUnapproveButton()
    {
        if($this->showBulkUnapprove && UsniAdaptor::app()->user->can($this->bulkApprovePermission))
        {
            $button = Html::button(FA::icon('remove') . "\n" . UsniAdaptor::t('application', 'Bulk Disapprove'), 
                                                                                          ["id" => "action-toolbar-bulkunapprove",
                                                                                          "class" => "btn btn-default bulk-unapprove-btn"]);
            return Html::tag('div', $button, ['class' => "btn-group"]);
        }
        return null;
    }
    
    /**
     * Renders trash button
     * @return string
     */
    public function renderTrashButton()
    {
        if($this->showTrash && UsniAdaptor::app()->user->can($this->deletePermission))
        {
            $label      = FA::icon('trash') . "\n" . UsniAdaptor::t('products', 'Trash');
            $url        = UsniAdaptor::createUrl('catalog/products/review/trash');
            $trashLink  = Html::a($label, $url, ['class' => 'btn btn-default']);
            return $trashLink;
        }
        return null;
    }
}
