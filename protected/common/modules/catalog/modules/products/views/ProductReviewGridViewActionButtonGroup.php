<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace products\views;

use usni\library\extensions\bootstrap\widgets\TranslatableGridViewActionButtonGroup;
use usni\UsniAdaptor;
use usni\library\components\UiHtml;
use usni\fontawesome\FA;
use usni\library\utils\BulkScriptUtil;
use usni\library\modules\auth\managers\AuthManager;
/**
 * ProductReviewGridViewActionButtonGroup class file.
 * @package products\views  
 */
class ProductReviewGridViewActionButtonGroup extends TranslatableGridViewActionButtonGroup
{
    /**
     * @inheritdoc
     */
    protected function setButtons()
    {
        $buttons['settings']       = $this->renderSettingsFormLink();
        $buttons['bulkDelete']     = $this->renderBulkDeleteButton();
        $buttons['bulkApprove']    = $this->renderBulkApproveButton();
        $buttons['bulkUnapprove']  = $this->renderBulkUnApproveButton();
        $buttons['trash']          = $this->renderTrashButton();
        $this->buttons = $buttons;
    }
    
    /**
     * Render bulk approve button.
     * @return string.
     */
    protected function renderBulkApproveButton()
    {
        $modelClass = strtolower(UsniAdaptor::getObjectClassName($this->model));
        if(AuthManager::checkAccess(UsniAdaptor::app()->user->getUserModel(), $modelClass . '.bulk-approve'))
        {
            $content         = null;
            $label           = FA::icon('check') . "\n" . UsniAdaptor::t('application', 'Bulk Approve');
            $content         = UiHtml::a($label, '#',
                                           ['class'         => 'btn btn-default bulk-approve-btn',]);
            $approveUrl      = UsniAdaptor::createUrl('/catalog/products/review/bulk-approve');
            $pjaxId          = $modelClass.'gridview-pjax';
            BulkScriptUtil::registerBulkApproveScript($approveUrl, 'grid-view', 'approve-btn', $this->getView(), $pjaxId);
            return $content;
        }
        return null;
    }
    /**
     * Render bulk unapprove button.
     * @return string
     */
    protected function renderBulkUnApproveButton()
    {
        $modelClass  = strtolower(UsniAdaptor::getObjectClassName($this->model));
        if(AuthManager::checkAccess(UsniAdaptor::app()->user->getUserModel(), $modelClass . '.bulk-approve'))
        {
            $content         = null;
            $label           = FA::icon('remove') . "\n" . UsniAdaptor::t('application', 'Bulk Disapprove');
            $content         = UiHtml::a($label, '#',
                                           ['class'         => 'btn btn-default bulk-unapprove-btn',]);
            $unapproveUrl  = UsniAdaptor::createUrl('/catalog/products/review/bulk-unapprove');
            $pjaxId      = $modelClass.'gridview-pjax';
            BulkScriptUtil::registerBulkUnApproveScript($unapproveUrl, 'grid-view', 'unapprove-btn', $this->getView(), $pjaxId);
            return $content;
        }
        return null;
    }
    
    /**
     * Render trash button.
     * @return string
     */
    protected function renderTrashButton()
    {
        $modelClassName = strtolower(UsniAdaptor::getObjectClassName($this->model));
        if(AuthManager::checkAccess(UsniAdaptor::app()->user->getUserModel(), $modelClassName . '.delete'))
        {
            $label          = FA::icon('trash') . "\n" . UsniAdaptor::t('products', 'Trash');
            $modelClassName = strtolower(UsniAdaptor::getObjectClassName($this->model));
            $url            = UsniAdaptor::createUrl('products/review/trash');
            $trashLink      = UiHtml::a($label, $url, ['class' => 'btn btn-default']);
            return $trashLink;
        }
        return null;
    }
}
