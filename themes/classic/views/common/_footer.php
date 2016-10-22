<?php
use usni\UsniAdaptor;
use usni\library\components\UiHtml;
use usni\library\utils\ConfigurationUtil;
?>
<!-- begin:footer -->
<footer>
    <div class="container">
        <div class="row">
            <div class="col-sm-3">
                <h5><?php echo UsniAdaptor::t('cms', 'Information'); ?></h5>
                <ul class="list-unstyled">
                    <li>
                        <?php echo UiHtml::a(UsniAdaptor::t('cms', 'About Us'), UsniAdaptor::createUrl('cms/site/page', ['alias' => 'about-us'])); ?>
                    </li>
                    <li>
                        <?php echo UiHtml::a(UsniAdaptor::t('cms', 'Delivery Information'), UsniAdaptor::createUrl('cms/site/page', ['alias' => 'delivery-info'])); ?>
                    </li>
                    <li>
                        <?php echo UiHtml::a(UsniAdaptor::t('cms', 'Privacy Policy'), UsniAdaptor::createUrl('cms/site/page', ['alias' => 'privacy-policy'])); ?>
                    </li>
                    <li>
                        <?php echo UiHtml::a(UsniAdaptor::t('cms', 'Terms & Conditions'), UsniAdaptor::createUrl('cms/site/page', ['alias' => 'terms'])); ?>
                    </li>
                </ul>
            </div>
            <div class="col-sm-3">
                <h5> <?php echo UsniAdaptor::t('customer', 'Customer Service'); ?> </h5>
                <ul class="list-unstyled">
                    <li>
                        <?php echo UiHtml::a(UsniAdaptor::t('cms', 'Contact Us'), UsniAdaptor::createUrl('site/default/contact-us')); ?>
                    </li>
                    <li>
                        <?php
                        $isEnabled = ConfigurationUtil::isModuleEnabled('marketing');
                        if($isEnabled)
                        {
                            $label = UsniAdaptor::t('newsletter', 'Join the newsletter');
                            echo UiHtml::a($label, '#',
                                            ['class'       => 'send-newsletter',
                                             'type'        => 'button',
                                             'data-toggle' => 'modal',
                                             'data-target' => '#sendNewsletterModal']);
                        }
                        ?>
                    </li>
                </ul>
            </div>
            <div class="col-sm-3">
                <h5> <?php echo UsniAdaptor::t('users', 'My Account'); ?> </h5>
                <ul class="list-unstyled">
                    <li> <?php echo UiHtml::a(UsniAdaptor::t('users', 'My Account'), UsniAdaptor::createUrl('customer/site/my-account')); ?> </li>
                    <li> <?php echo UiHtml::a(UsniAdaptor::t('order', 'Order History'), UsniAdaptor::createUrl('customer/site/order-history')); ?> </li>
                    <li> <?php echo UiHtml::a(UsniAdaptor::t('cart', 'Shopping Cart'), UsniAdaptor::createUrl('cart/default/view')); ?> </li>
                    <li> <?php echo UiHtml::a(UsniAdaptor::t('cart', 'Checkout'), UsniAdaptor::createUrl('cart/checkout/index')); ?> </li>
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
        <p><?php echo $powered; ?></p>
    </div>
</footer>
<!-- end:footer -->