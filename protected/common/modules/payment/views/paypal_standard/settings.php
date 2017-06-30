<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
use usni\UsniAdaptor;
use usni\library\bootstrap\TabbedActiveForm;
use usni\library\bootstrap\FormButtons;
use usni\library\widgets\Tabs;

/* @var $formDTO \common\modules\payment\dto\PaypalStandardFormDTO */
/* @var $form \usni\library\bootstrap\TabbedActiveForm */
/* @var $this \usni\library\web\AdminView */

$title = UsniAdaptor::t('payment', 'Paypal Settings');
$this->params['breadcrumbs'] = [    
                                    [
                                        'label' => UsniAdaptor::t('application', 'Manage') . ' ' . UsniAdaptor::t('payment', 'Payments'),
                                        'url'   => ['/payment/default/index']
                                    ],
                                    [
                                        'label' => $title
                                    ]
                               ];

$this->title = $title;
$form = TabbedActiveForm::begin([
                                    'id'          => 'paypalsettingeditview', 
                                    'layout'      => 'horizontal',
                                    'caption'     => $title
                               ]); 
?>
<?php
            $items[] = [
                'options' => ['id' => 'tabpaypalsetting'],
                'label' => UsniAdaptor::t('payment', 'Paypal Settings'),
                'class' => 'active',
                'content' => $this->render('/paypal_standard/_paypalsetting', ['form' => $form, 'formDTO' => $formDTO])
            ];
            $items[] = [
                'options' => ['id' => 'taborderstatusview'],
                'label' => UsniAdaptor::t('orderstatus', 'Order Status'),
                'content' => $this->render('/paypal_standard/_orderstatusview', ['form' => $form, 'formDTO' => $formDTO])
            ];
            echo Tabs::widget(['items' => $items]);
    ?>
<?= FormButtons::widget(['cancelUrl' => UsniAdaptor::createUrl('payment/default/index')]);?>
<?php TabbedActiveForm::end();