<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace wishlist\widgets;

use common\utils\ApplicationUtil;
use usni\UsniAdaptor;
/**
 * TopNavWishlist renders wishlist content in the top navigation
 *
 * @package wishlist\widgets
 */
class TopNavWishlist extends \yii\bootstrap\Widget
{
    /**
     * inheritdoc
     */
    public function run()
    {
        $wishlist   = ApplicationUtil::getWishList();
        $count      = $wishlist->getCount();
        $label      = UsniAdaptor::t('wishlist', 'Wish List');
        if($count > 0)
        {
            return $label . ' (' . $count . ')';
        }
        return $label;
    }
}
