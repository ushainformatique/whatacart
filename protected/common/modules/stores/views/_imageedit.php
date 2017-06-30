<?php
use usni\library\utils\FileUploadUtil;
use usni\library\utils\Html;
use usni\UsniAdaptor;

/* @var $formDTO \common\modules\stores\dto\FormDTO */
/* @var $form \usni\library\bootstrap\ActiveForm */

$model = $formDTO->getModel()->storeImage;
$logo = null;
$icon = null;
if($model->scenario == 'update')
{
    if ($model->store_logo != null)
    {
        $logo   = FileUploadUtil::getThumbnailImage($model, 'store_logo');
    }
    if ($model->icon != null)
    {
        $icon   = Html::img(UsniAdaptor::app()->getAssetManager()->getImageUploadUrl() . DS . $model->icon);
    }
}

?>
<?= $form->field($model, 'store_logo')->fileInput();?>
<?= $logo;?>
<?= $form->field($model, 'icon')->fileInput();?>
<?= $icon;?>
<div class="row">
    <div class="col-sm-6">
        <?= $form->field($model, 'category_image_width')->textInput();?>
    </div>
    <div class="col-sm-6">
        <?= $form->field($model, 'category_image_height')->textInput();?>
    </div>
</div>
<div class="row">
    <div class="col-sm-6">
        <?= $form->field($model, 'product_list_image_width')->textInput();?>
    </div>
    <div class="col-sm-6">
        <?= $form->field($model, 'product_list_image_height')->textInput();?>
    </div>
</div>
<div class="row">
    <div class="col-sm-6">
        <?= $form->field($model, 'related_product_image_width')->textInput();?>
    </div>
    <div class="col-sm-6">
        <?= $form->field($model, 'related_product_image_height')->textInput();?>
    </div>
</div>

<div class="row">
    <div class="col-sm-6">
        <?= $form->field($model, 'compare_image_width')->textInput();?>
    </div>
    <div class="col-sm-6">
        <?= $form->field($model, 'compare_image_height')->textInput();?>
    </div>
</div>

<div class="row">
    <div class="col-sm-6">
        <?= $form->field($model, 'wishlist_image_width')->textInput();?>
    </div>
    <div class="col-sm-6">
        <?= $form->field($model, 'wishlist_image_height')->textInput();?>
    </div>
</div>

<div class="row">
    <div class="col-sm-6">
        <?= $form->field($model, 'cart_image_width')->textInput();?>
    </div>
    <div class="col-sm-6">
        <?= $form->field($model, 'cart_image_height')->textInput();?>
    </div>
</div>

<div class="row">
    <div class="col-sm-6">
        <?= $form->field($model, 'store_image_width')->textInput();?>
    </div>
    <div class="col-sm-6">
        <?= $form->field($model, 'store_image_height')->textInput();?>
    </div>
</div>