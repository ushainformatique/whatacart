<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace cart\controllers;

use frontend\controllers\BaseController;
use usni\UsniAdaptor;
use yii\helpers\Json;
use cart\widgets\HeaderCartSubView;
use common\utils\ApplicationUtil;
use cart\dto\CartDTO;
use cart\business\Manager;
use cart\widgets\SiteCartSubView;
/**
 * DefaultController class file
 *
 * @package cart\controllers
 */
class DefaultController extends BaseController
{
    /**
     * @var Manager 
     */
    public $manager;
    
    /**
     * inheritdoc
     */
    public function beforeAction($action)
    {
        if(parent::beforeAction($action))
        {
            $this->manager = Manager::getInstance();
            return true;
        }
        return false;
    }
    
    /**
     * Add product to add to cart
     * @return string json result
     */
    public function actionAddToCart()
    {
        $isDetail       = (bool)$_POST['isDetail'];
        $cart           = ApplicationUtil::getCart();      
        //Populate dtos
        $cartDTO    = new CartDTO();
        $cartDTO->setPostData($_POST);
        $cartDTO->setCart($cart);
        $cartDTO->setCustomerId(ApplicationUtil::getCustomerId());
        $this->manager->addItem($cartDTO);
        $result = $cartDTO->getResult();
        if($result['success'] === true)
        {
            $cartDTO->getCart()->updateSession();
            $data       = HeaderCartSubView::widget();
            $result['data'] = $data;
        }
        elseif($result['qtyError'] === true)
        {
            if($isDetail == false)
            {
                $this->redirect(UsniAdaptor::createUrl('products/site/detail', ['id' => $_POST['product_id']]))->send();
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
        return $this->render('/view');
    }
    
    /**
     * Remove item from cart.
     * @return string
     */
    public function actionRemove()
    {
        if(UsniAdaptor::app()->request->getIsAjax())
        {
            $cart       = ApplicationUtil::getCart();
            $cartDTO    = new CartDTO();
            $cartDTO->setCart($cart);
            $this->manager->removeItem($_POST['item_code'], $cartDTO);
            $cartDTO->getCart()->updateSession();
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
            $cart           = ApplicationUtil::getCart();
            $cartDTO        = new CartDTO();
            $cartDTO->setCart($cart);
            $cartDTO->setPostData($_POST);
            $result         = $this->manager->updateItem($cartDTO);
            if($result === true)
            {
                $cart->updateSession();
                $headerCartContent = HeaderCartSubView::widget();
                $content           = SiteCartSubView::widget();
                return Json::encode(['content' => $content, 'headerCartContent' => $headerCartContent]);
            }
            else
            {
                return $result;
            }
        }
        return Json::encode([]);
    }
}