<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\bootstrap;

use usni\library\utils\Html;
/**
 * Override bootstrap ActiveField class for changes specific to bulk edit.
 * 
 * @package usni\library\bootstrap
 */
class BulkEditActiveField extends ActiveField
{
    /**
     * inheritdoc
     */
    public function render($content = null)
    {
        $activeId   = Html::getInputId($this->model, $this->attribute);
        $checkBox   = Html::checkBox('chk_' . $activeId, false, ['data-id' => $activeId, 'class' => 'selectBulkEdit']);
        $checkBox   = Html::tag('div', $checkBox, ['class' => 'col-sm-1 checkbox bulk-edit-chk']);
        $this->parts['{checkbox}'] = $checkBox;
        return parent::render($content);
    }
    
    /**
     * inheritdoc
     */
    public function select2Input($items, $enableSearch = true, $options = [], $select2Options = [])
    {
        $options['disabled'] = 'disabled';
        return parent::select2Input($items, $enableSearch, $options, $select2Options);
    }
}
