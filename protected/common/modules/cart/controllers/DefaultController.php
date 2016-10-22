<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace cart\controllers;

use frontend\controllers\BaseController;
use usni\UsniAdaptor;
use yii\helpers\Json;
use frontend\utils\FrontUtil;
use cart\views\HeaderCartSubView;
use frontend\components\Breadcrumb;
use cart\utils\CartUtil;
use common\utils\ApplicationUtil;
use products\utils\ProductUtil;
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
    public function actionAddToCart()
    {
        $product  = ProductUtil::getProduct($_POST['product_id']);
        $isDetail = (bool)$_POST['isDetail'];
        $cart     = ApplicationUtil::getCart();      
        $inputOptions   = [];
        if(isset($_POST['ProductOptionMapping']['option']))
        {
            $inputOptions = $_POST['ProductOptionMapping']['option'];
        }
        $result = CartUtil::processAddToCartItem($cart, $product, $_POST['quantity'], $inputOptions);
        if($result['success'] === true)
        {
            $subView    = new HeaderCartSubView();
            $data       = $subView->render();
            $result['data'] = $data;
        }
        elseif($result['qtyError'] === true)
        {
            if($isDetail == false)
            {
                $this->redirect(UsniAdaptor::createUrl('products/site/detail', ['id' => $product->id]))->send();
            }
        }
        echo Json::encode($result);
    }
    
    /**
     * View shopping cart
     * @return string
     */
    public function actionView()
    {
        $this->getView()->title = UsniAdaptor::t('cart', 'Shopping Cart');
        $breadcrumbView     = new Breadcrumb(['page' => $this->getView()->title]);
        $this->getView()->params['breadcrumbs'] = $breadcrumbView->getBreadcrumbLinks();
        $viewHelper         = UsniAdaptor::app()->getModule('cart')->viewHelper;
        $detailView         = $viewHelper->getInstance('cartDetailView');
        $content     = $this->renderInnerContent([$detailView]);
        return $this->render(FrontUtil::getDefaultInnerLayout(), ['content' => $content]);
    }
    
    /**
     * Remove item from cart.
     * @return string
     */
    public function actionRemove()
    {
        if(UsniAdaptor::app()->request->getIsAjax())
        {
            $cart              = ApplicationUtil::getCart();
            $cart->removeItem($_POST['item_code']);
        }
        return Json::encode([]);
    }
    
    /**
     * Update items into cart.
     * @return string
     */
    public function actionUpdate()
    {
        if(UsniAdaptor::app()->request->getIsAjax())
        {
            $itemCode          = $_POST['item_code'];
            $cart              = ApplicationUtil::getCart();
            $cart->itemsList[$itemCode]['qty'] = $_POST['qty'];
            $cart->updateSession();
            $headerSubView     = new HeaderCartSubView();
            $headerCartContent = $headerSubView->render();
            //$cartSubView       = new CartSubView();
            $viewHelper        = UsniAdaptor::app()->getModule('cart')->viewHelper;
            $cartSubView       = $viewHelper->getInstance('cartSubView');
            $content           = $cartSubView->render();
            return Json::encode(['content' => $content, 'headerCartContent' => $headerCartContent]);
        }
        return Json::encode([]);
    }
}
?>