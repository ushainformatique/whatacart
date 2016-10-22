<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace products\views\front;

use frontend\utils\FrontUtil;
use products\utils\ProductUtil;
use usni\library\components\UiHtml;
use products\utils\CompareProductsUtil;
use wishlist\utils\WishlistUtil;
use usni\UsniAdaptor;
use common\modules\stores\utils\StoreUtil;
use usni\library\views\UiView;
/**
 * BestSellerListView class file
 *
 * @package products\views
 */
class BestSellerListView extends UiView
{   
    /**
     * @inheritdoc
     */
    protected function renderContent()
    {
        return "Best seller list view";
    }
}
?>