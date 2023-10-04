<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\modules\users\widgets;

/**
 * Implement common functions related to user grid
 *
 * @package usni\library\modules\users\widgets
 */
class ActionToolbar extends \usni\library\grid\ActionToolbar
{
    /**
     * @var array 
     */
    public $groupList;
    
    /**
     * @inheritdoc
     */
    public function renderBulkEditForm()
    {
        if($this->showBulkEdit)
        {
            $formContent = $this->render($this->bulkEditFormView, ['groupList' => $this->groupList]);
            return str_replace('{content}', $formContent, $this->bulkEditFormLayout);
        }
        return null;
    }
}
