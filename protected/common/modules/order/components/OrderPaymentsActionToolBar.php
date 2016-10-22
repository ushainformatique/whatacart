<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\order\components;

/**
 * OrderPaymentsActionToolBar class file.
 *
 * @package common\modules\order\components
 */
class OrderPaymentsActionToolBar extends \usni\library\extensions\bootstrap\widgets\UiGridViewActionToolBar
{
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->pjaxId = 'orderpaymentsgridview-pjax';
    }
}