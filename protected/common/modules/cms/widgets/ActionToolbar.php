<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\cms\widgets;

use usni\UsniAdaptor;
/**
 * Implement common functions related to page grid
 *
 * @package common\modules\cms\widgets
 */
class ActionToolbar extends \usni\library\grid\ActionToolbar
{
    /**
     * @var array 
     */
    public $parentDropdownOptions;
    
    /**
     * @inheritdoc
     */
    public function renderBulkEditForm()
    {
        $bulkEditPermission = true;
        if($this->bulkEditPermission != null)
        {
            $bulkEditPermission = UsniAdaptor::app()->user->can($this->bulkEditPermission);
        }
        if($this->showBulkEdit && $bulkEditPermission)
        {
            $formContent = $this->render($this->bulkEditFormView, ['parentDropdownOptions' => $this->parentDropdownOptions]);
            return str_replace('{content}', $formContent, $this->bulkEditFormLayout);
        }
        return null;
    }
}
