<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace customer\components;

use usni\UsniAdaptor;
use usni\library\components\UiWebUser;
use yii\web\UserEvent;
use usni\library\modules\users\components\LoginBehavior as BaseLoginBehavior;
use cart\models\Cart;
use cart\utils\CartUtil;
use wishlist\utils\WishlistUtil;
use wishlist\models\Wishlist;
use products\utils\CompareProductsUtil;
use products\models\CompareProducts;
/**
 * LoginBehavior class file.
 * The methods would be used when afterLogin event is raised by the application.
 * 
 * @package customer\components
 */
class LoginBehavior extends BaseLoginBehavior
{
    /**
     * @inheritdoc
     */
    public function events()
    {
        return array(UiWebUser::EVENT_AFTER_LOGIN => array($this, 'processAfterLogin'));
    }

    /**
     * @inheritdoc
     */
    public function processAfterLogin(UserEvent $event)
    {
        CartUtil::populateCustomerMetadataInSession();
        WishlistUtil::populateCustomerMetadataInSession();
        CompareProductsUtil::populateCustomerMetadataInSession();
        UsniAdaptor::app()->guest->updateSession('cart', new Cart());
        UsniAdaptor::app()->guest->updateSession('wishlist', new Wishlist());
        UsniAdaptor::app()->guest->updateSession('compareproducts', new CompareProducts());
        //Populate wish list
        parent::processAfterLogin($event);
    }
}