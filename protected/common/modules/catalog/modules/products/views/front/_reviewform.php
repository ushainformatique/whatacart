<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */

/* @var $model \products\models\ProductReview */

use frontend\widgets\ActiveForm;
use usni\library\utils\Html;
use usni\UsniAdaptor;
use frontend\widgets\FormButtons;

$userModel = UsniAdaptor::app()->user->getIdentity();
$isHidden  = false;
if($userModel != null)
{
    $isHidden  = true;
    if($userModel->person->firstname == null)
    {
        $fullName = $userModel->username;
    }
    else
    {
        $fullName = $userModel->person->getFullName();
    }
}
?>
<div id="reviewformcontainer">
    <div class="alert alert-success alert-review">
        <?php echo UsniAdaptor::t('productflash', 'Thank you for your review. It has been submitted to the admin for approval.');?>
    </div>
    <?php $form = ActiveForm::begin(['id' => 'review-form', 
                                     'layout' => 'horizontal',
                                     'decoratorView' => false,
                                     'view' => $this]); ?>
    <legend id="review-title">
        <?php echo UsniAdaptor::t('products', 'Write Review');?>
    </legend>
    <?php
    if($isHidden)
    {
        $model->name  = $fullName;
        $model->email = $userModel->person->email;
        echo Html::activeHiddenInput($model, 'name');
        echo Html::activeHiddenInput($model, 'email');
    }
    else
    {
        echo $form->field($model, 'name')->textInput();
        echo $form->field($model, 'email')->textInput();
    }
    ?>
    <?= $form->field($model, 'review')->textarea(['cols' => 10, 'rows' => 10, 'maxlength' => 200]);?>    
    <?= Html::activeHiddenInput($model, 'product_id');?>
    <?= Html::activeHiddenInput($model, 'status');?>
    <?= FormButtons::widget(['layout' => "<div class='form-actions text-right'>{submit}\n{cancel}</div>",
                                'submitButtonLabel' => UsniAdaptor::t('application', 'Submit'),
                                'showCancelButton' => false])?>
    <?php ActiveForm::end(); ?>
</div>
<?php
$url            = UsniAdaptor::createUrl('catalog/products/site/review');
$js             = "$('#review-form').on('beforeSubmit',
                             function(event)
                             {
                                var form = $(this);
                                if(form.find('.has-error').length) {
                                        return false;
                                }
                                $.ajax({
                                        'type':'POST',
                                        'url': '{$url}',
                                        'data':form.serialize(),
                                        'beforeSend' : function()
                                                        {
                                                            attachButtonLoader(form);
                                                            $('.alert-review').hide();
                                                        },

                                        'success':function(data)
                                                  {
                                                      $('#review-form')[0].reset();
                                                      $('.alert-review').show();
                                                      removeButtonLoader(form);
                                                  },
                                        });
                                      return false;
                            })";
$this->registerJs($js);
$js = "$( document ).ready(function() {
            $('.alert-review').hide();
    });";
$this->registerJs($js);