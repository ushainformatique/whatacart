<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
use usni\fontawesome\FA;
use usni\library\utils\Html;
use usni\UsniAdaptor;

/* @var $formDTO \products\dto\FormDTO */
/* @var $this \usni\library\web\AdminView */
$editLabel  = FA::icon('pencil') . "\n" . UsniAdaptor::t('application','Edit');
echo Html::a($editLabel, UsniAdaptor::createUrl("catalog/products/attribute/assign", ["productId" => $formDTO->model->id]), 
                                ['class' => 'btn btn-default', 'id' => 'attributes-edit-link']);

echo $this->render('/_assignedAttributesGridView', ['dataProvider' => $formDTO->getAttributesDataProvider(),
                                            'layout' => "<div class='panel panel-content'><div class='panel-body'>{summary}\n{items}\n</div></div>",
                                            'showActionColumn' => false]);