<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\shipping\components;

use usni\library\extensions\bootstrap\widgets\UiGridViewActionToolBar;
/**
 * ShippingGridViewActionToolBar class file.
 * 
 * @package products\views
 */
class ShippingGridViewActionToolBar extends UiGridViewActionToolBar
{
    /**
     * @inheritdoc
     */
    public function getGridViewActionButtonGroup()
    {
        return ShippingGridViewActionButtonGroup::className();
    }
}
