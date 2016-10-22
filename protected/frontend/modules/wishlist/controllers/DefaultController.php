<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace wishlist\controllers;

use frontend\controllers\BaseController;
use wishlist\views\DetailView;
use usni\UsniAdaptor;
use yii\helpers\Json;
use frontend\utils\FrontUtil;
use wishlist\utils\WishlistUtil;
use customer\components\AccountBreadcrumb;
use common\utils\ApplicationUtil;
use wishlist\views\WishlistSubView;
use common\modules\stores\utils\StoreUtil;
/**
 * DefaultController class file
 * @package cart\controllers
 */
class DefaultController extends BaseController
{
    /**
     * Add product to add to cart
     * @return string json result
     */
    public function actionAddToWishlist()
    {
        $wishlist   = ApplicationUtil::getWishList();
        $wishlist->addItem($_POST['productId']);
        $data       = WishlistUtil::renderWishlistInTopnav();
        $result     = ['success' => true, 'data' => $data];
        echo Json::encode($result);
    }
    
    /**
     * View shopping cart
     * @return string
     */
    public function actionView()
    {
        $wishlistSetting = StoreUtil::getSettingValue('allow_wishlist');
        if($wishlistSetting)
        {
            $breadcrumbView     = new AccountBreadcrumb(['page' => UsniAdaptor::t('wishlist', 'My Wish List')]);
            $this->getView()->params['breadcrumbs'] = $breadcrumbView->getBreadcrumbLinks();
            $detailView  = new DetailView();
            $content     = $this->renderInnerContent([$detailView]);
            return $this->render(FrontUtil::getDefaultInnerLayout(), ['content' => $content]);
        }
        else
        {
            throw new \yii\web\NotFoundHttpException();
        }
    }
    
    /**
     * Remove item from cart.
     * @return string
     */
    public function actionRemove()
    {
        if(UsniAdaptor::app()->request->getIsAjax())
        {
            $wishlist          = ApplicationUtil::getWishList();
            $wishlist->removeItem($_POST['product_id']);
            $headerContent     = WishlistUtil::renderWishlistInTopnav();
            $view              = new WishlistSubView();
            $detail            = $view->render();
            return Json::encode(['success' => true, 'content' => $detail, 'headerWishlistContent' => $headerContent]);
        }
        return Json::encode([]);
    }
}
?>