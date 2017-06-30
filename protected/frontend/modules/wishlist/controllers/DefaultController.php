<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace wishlist\controllers;

use frontend\controllers\BaseController;
use usni\UsniAdaptor;
use yii\helpers\Json;
use common\utils\ApplicationUtil;
use wishlist\widgets\WishlistSubView;
use wishlist\widgets\TopNavWishlist;
use wishlist\business\Manager;
/**
 * DefaultController class file
 * 
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
        $data       = TopNavWishlist::widget();
        $result     = ['success' => true, 'data' => $data];
        echo Json::encode($result);
    }
    
    /**
     * View shopping cart
     * @return string
     */
    public function actionView()
    {
        $wishlistSetting = UsniAdaptor::app()->storeManager->getSettingValue('allow_wishlist');
        if($wishlistSetting)
        {
            $products = Manager::getInstance()->prepareWishlist(ApplicationUtil::getWishList());
            return $this->render('/view', ['products' => $products]);
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
            $wishlist           = ApplicationUtil::getWishList();
            $wishlist->removeItem($_POST['product_id']);
            $headerContent      = TopNavWishlist::widget();
            $products           = Manager::getInstance()->prepareWishlist(ApplicationUtil::getWishList());
            $detail             = WishlistSubView::widget(['products' => $products]);
            return Json::encode(['success' => true, 'content' => $detail, 'headerWishlistContent' => $headerContent]);
        }
        return Json::encode([]);
    }
}