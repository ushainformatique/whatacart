<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\order\views\front;

use common\modules\order\views\OrderHistoryView as BaseHistoryView;
/**
 * OrderHistoryView class file.
 *
 * @package common\modules\order\views\front
 */
class OrderHistoryView extends BaseHistoryView
{
    /**
     * @inheritdoc
     */
    protected function shouldRenderEditView()
    {
        return false;
    }
}
?>