<?php
use usni\UsniAdaptor;
use usni\library\utils\Html;
use common\modules\stores\models\Store;
use newsletter\models\NewsletterCustomers;

/* @var $this \frontend\web\View */
?>
<!-- begin:footer -->
<footer>
    <div class="container">
        <div class="row">
            <div class="col-sm-3">
                <h5><?php echo UsniAdaptor::t('cms', 'Information'); ?></h5>
                <ul class="list-unstyled">
                    <li>
                        <?php echo Html::a(UsniAdaptor::t('cms', 'About Us'), UsniAdaptor::createUrl('cms/site/page', ['alias' => UsniAdaptor::t('cms', 'about-us')])); ?>
                    </li>
                    <li>
                        <?php echo Html::a(UsniAdaptor::t('cms', 'Delivery Information'), UsniAdaptor::createUrl('cms/site/page', ['alias' => UsniAdaptor::t('cms', 'delivery-info')])); ?>
                    </li>
                    <li>
                        <?php echo Html::a(UsniAdaptor::t('cms', 'Privacy Policy'), UsniAdaptor::createUrl('cms/site/page', ['alias' => UsniAdaptor::t('cms', 'privacy-policy')])); ?>
                    </li>
                    <li>
                        <?php echo Html::a(UsniAdaptor::t('cms', 'Terms & Conditions'), UsniAdaptor::createUrl('cms/site/page', ['alias' => UsniAdaptor::t('cms', 'terms')])); ?>
                    </li>
                </ul>
            </div>
            <div class="col-sm-3">
                <h5> <?php echo UsniAdaptor::t('customer', 'Customer Service'); ?> </h5>
                <ul class="list-unstyled">
                    <li>
                        <?php echo Html::a(UsniAdaptor::t('cms', 'Contact Us'), UsniAdaptor::createUrl('site/default/contact-us')); ?>
                    </li>
                    <li>
                        <?php
                        $label = UsniAdaptor::t('newsletter', 'Join the newsletter');
                        echo Html::a($label, '#',
                                        ['class'       => 'send-newsletter',
                                         'type'        => 'button',
                                         'data-toggle' => 'modal',
                                         'data-target' => '#sendNewsletterModal']);
                        echo $this->render('@newsletter/views/front/sendnewsletter', ['model' => new NewsletterCustomers(['scenario' => 'send'])]);
                        ?>
                    </li>
                </ul>
            </div>
            <div class="col-sm-3">
                <h5> <?php echo UsniAdaptor::t('users', 'My Account'); ?> </h5>
                <ul class="list-unstyled">
                    <li> <?php echo Html::a(UsniAdaptor::t('users', 'My Account'), UsniAdaptor::createUrl('customer/site/my-account')); ?> </li>
                    <li> <?php echo Html::a(UsniAdaptor::t('order', 'Order History'), UsniAdaptor::createUrl('customer/site/order-history')); ?> </li>
                    <li> <?php echo Html::a(UsniAdaptor::t('cart', 'Shopping Cart'), UsniAdaptor::createUrl('cart/default/view')); ?> </li>
                    <li> <?php echo Html::a(UsniAdaptor::t('cart', 'Checkout'), UsniAdaptor::createUrl('cart/checkout/index')); ?> </li>
                </ul>
            </div>
            <div class="col-sm-3">
                <h5> <?php echo UsniAdaptor::t('application', 'Social'); ?> </h5>
                <p>
                    <a href="#"><i class="fa fa-twitter"></i></a> &nbsp;
                    <a href="#"><i class="fa fa-facebook"></i></a> &nbsp;
                    <a href="#"><i class="fa fa-rss"></i></a>
                </p>
            </div>
        </div>
        <hr>
        <?php
            $currentStore   = UsniAdaptor::app()->storeManager->selectedStore;
            if($currentStore['id'] == Store::DEFAULT_STORE_ID)
            {
                $storeName  = UsniAdaptor::t('stores', 'Default Store');
            }
            else
            {
                $storeName = $currentStore['name'];
            }
            echo '<p>Copyright &copy; ' . date("Y") . " " . $storeName . '. All Rights Reserved.' . UsniAdaptor::app()->powered() . '</p>';
        ?>
    </div>
</footer>
<!-- end:footer -->