<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\cms\components;

use usni\library\extensions\bootstrap\widgets\UiDataColumn;
use common\modules\cms\utils\DropdownUtil;
/**
 * StatusDataColumn class file.
 * 
 * @package common\modules\cms\components
 */
class StatusDataColumn extends UiDataColumn
{
    /**
     * @inheritdoc
     */
    protected function renderDataCellContent($model, $key, $index)
    {
        return DropdownUtil::renderLabel($model);
    }
}