<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace frontend\views\common;

use usni\UsniAdaptor;

/**
 * StoreView class file.
 *
 * @package frontend\views\commmon
 */
class StoreView extends \common\modules\stores\views\StoreView
{
    /**
     * @inheritdoc
     */
    protected function getUrl()
    {
        return UsniAdaptor::createUrl('customer/site/set-store');
    }
}