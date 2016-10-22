<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace cart\views;

use usni\UsniAdaptor;
/**
 * ProductCartSubView class file. This would be used on order detail view product tab in front
 * @package cart\views
 */
class ProductCartSubView extends CartSubView
{
    /**
     * @inheritdoc
     */
    protected function getItemViewFile()
    {
        return UsniAdaptor::getAlias('@common/modules/cart/views/_confirmCartItem.php');
    }
}