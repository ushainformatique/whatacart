<?php
use usni\UsniAdaptor;
use usni\library\utils\Html;
use usni\fontawesome\FA;

/* @var $formDTO \products\dto\FormDTO */

$editLabel  = FA::icon('pencil') . "\n" . UsniAdaptor::t('application', 'Edit');
$editLink   = Html::a($editLabel, UsniAdaptor::createUrl("catalog/products/option/assign", ["productId" => $formDTO->model->id]), 
                                ['class' => 'btn btn-default', 'id' => 'options-edit-link']);
echo $editLink . "<br/><br/>";

echo $this->render('/_manageOptionValuesSubView', ['assignedOptions' => $formDTO->getAssignedOptions()]);
