<?php
use usni\UsniAdaptor;
use usni\library\utils\Html;
use usni\library\utils\AdminUtil;

$catalog            = Html::tag('legend', UsniAdaptor::t('catalog', 'Catalog'));
$tax                = Html::tag('legend', UsniAdaptor::t('tax', 'Taxes'));
$account            = Html::tag('legend', UsniAdaptor::t('users', 'Account'));
$checkout           = Html::tag('legend', UsniAdaptor::t('cart', 'Checkout'));
$stock              = Html::tag('legend', UsniAdaptor::t('products', 'Stock'));
$reviews            = Html::tag('legend', UsniAdaptor::t('products', 'Reviews'));
$wishlist           = Html::tag('legend', UsniAdaptor::t('wishlist', 'Wishlist'));
$compareProducts    = Html::tag('legend', UsniAdaptor::t('products', 'Compare Products'));
$local              = Html::tag('legend', UsniAdaptor::t('localization', 'Local'));

/* @var $formDTO \common\modules\stores\dto\FormDTO */
/* @var $form \usni\library\bootstrap\ActiveForm */

$model = $formDTO->getModel()->storeSettings;
?>
<?= $catalog;?>
<?= $form->field($model, 'catalog_items_per_page')->textInput();?>
<?= $form->field($model, 'list_description_limit')->textInput();?>
<?= $tax;?>
<?= $form->field($model, 'display_price_with_tax')->dropDownList(AdminUtil::getYesNoOptions());?>
<?= $form->field($model, 'tax_calculation_based_on')->dropDownList($formDTO->getTaxBasedOnOptions());?>
<?= $account;?>
<?= $form->field($model, 'customer_online')->dropDownList(AdminUtil::getYesNoOptions());?>
<?= $form->field($model, 'default_customer_group')->select2input($formDTO->getCustomerGroupOptions());?>
<?= $form->field($model, 'customer_prefix')->textInput();?>
<?= $checkout;?>
<?= $form->field($model, 'invoice_prefix')->textInput();?>
<?= $form->field($model, 'order_prefix')->textInput();?>
<?= $form->field($model, 'guest_checkout')->dropDownList(AdminUtil::getYesNoOptions());?>
<?= $form->field($model, 'order_status')->select2input($formDTO->getOrderStatusOptions());?>
<?= $stock;?>
<?= $form->field($model, 'display_stock')->dropDownList(AdminUtil::getYesNoOptions());?>
<?= $form->field($model, 'show_out_of_stock_warning')->dropDownList(AdminUtil::getYesNoOptions());?>
<?= $form->field($model, 'allow_out_of_stock_checkout')->dropDownList(AdminUtil::getYesNoOptions());?>
<?= $reviews;?>
<?= $form->field($model, 'allow_reviews')->dropDownList(AdminUtil::getYesNoOptions());?>
<?= $form->field($model, 'allow_guest_reviews')->dropDownList(AdminUtil::getYesNoOptions());?>

<?= $wishlist;?>
<?= $form->field($model, 'allow_wishlist')->dropDownList(AdminUtil::getYesNoOptions());?>

<?= $compareProducts;?>
<?= $form->field($model, 'allow_compare_products')->dropDownList(AdminUtil::getYesNoOptions());?>

<?= $local;?>
<?= $form->field($model, 'display_dimensions')->dropDownList(AdminUtil::getYesNoOptions());?>
<?= $form->field($model, 'display_weight')->dropDownList(AdminUtil::getYesNoOptions());?>