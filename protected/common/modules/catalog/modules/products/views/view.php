<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
use usni\UsniAdaptor;
use usni\library\widgets\DetailActionToolbar;
use usni\fontawesome\FA;
use usni\library\widgets\Tabs;
use usni\library\widgets\DetailBrowseDropdown;
use products\behaviors\PriceBehavior;

/* @var $detailViewDTO \usni\library\dto\DetailViewDTO */
/* @var $this \usni\library\web\AdminView */

$this->attachBehavior('priceBehavior', PriceBehavior::className());
$model          = $detailViewDTO->getModel();
$this->title    = UsniAdaptor::t('application', 'View') . ' ' . UsniAdaptor::t('products', 'Product');
$this->params['breadcrumbs'] =  [
                                    [
                                        'label' => UsniAdaptor::t('application', 'Manage') . ' ' .
                                        UsniAdaptor::t('products', 'Products'),
                                        'url' => ['/catalog/products/default/index']
                                    ],
                                    [
                                        'label' => UsniAdaptor::t('application', 'View') . ' #' . $model['id']
                                    ]
                                ];

$browseParams   = ['permission' => 'product.viewother',
                   'model' => $model,
                   'data'  => $detailViewDTO->getBrowseModels(),
                   'modalDisplay' => $detailViewDTO->getModalDisplay()];

echo DetailBrowseDropdown::widget($browseParams);
$toolbarParams  = ['editUrl'            => UsniAdaptor::createUrl('catalog/products/default/update', ['id' => $model['id']]),
                   'deleteUrl'          => UsniAdaptor::createUrl('catalog/products/default/delete', ['id' => $model['id']])];
?>
<div class="panel panel-default detail-container">
    <div class="panel-heading">
        <h6 class="panel-title"><?php echo FA::icon('book') . $model['name'];?></h6>
            <?php
                echo DetailActionToolbar::widget($toolbarParams);
            ?>
    </div>
    <?php
            $items[] = [
                'options' => ['id' => 'tabgeneral'],
                'label' => UsniAdaptor::t('application', 'General'),
                'class' => 'active',
                'content' => $this->render('/detail/_general', ['detailViewDTO' => $detailViewDTO])
            ];
            $items[] = [
                'options' => ['id' => 'tabdata'],
                'label' => UsniAdaptor::t('products', 'Data'),
                'content' => $this->render('/detail/_data', ['detailViewDTO' => $detailViewDTO])
            ];
            $items[] = [
                'options' => ['id' => 'tabspec'],
                'label' => UsniAdaptor::t('products', 'Specifications'),
                'content' => $this->render('/detail/_specifications', ['detailViewDTO' => $detailViewDTO])
            ];
            $items[] = [
                'options' => ['id' => 'tabrelated'],
                'label' => UsniAdaptor::t('products', 'Related'),
                'content' => $this->render('/detail/_related', ['detailViewDTO' => $detailViewDTO])
            ];
            $items[] = [
                'options' => ['id' => 'taboptions'],
                'label' => UsniAdaptor::t('products', 'Options'),
                'content' => $this->render('/_manageOptionValuesSubView', ['assignedOptions' => $model['assignedOptions']])
            ];
            $items[] = [
                'options' => ['id' => 'tabattributes'],
                'label' => UsniAdaptor::t('products', 'Attributes'),
                'content' => $this->render('/_assignedAttributesGridView', ['dataProvider' => $model['attributesDataProvider'],
                                            'layout' => "<div class='panel panel-content'><div class='panel-body'>{summary}\n{items}\n</div></div>",
                                            'showActionColumn' => false])
            ];
            $items[] = [
                'options' => ['id' => 'tabdiscount'],
                'label' => UsniAdaptor::t('products', 'Discounts'),
                'content' => $this->render('/detail/_discount', ['productDiscounts' => $model['productDiscounts']])
            ];
            $items[] = [
                'options' => ['id' => 'tabspecial'],
                'label' => UsniAdaptor::t('products', 'Specials'),
                'content' => $this->render('/detail/_special', ['productSpecials' => $model['productSpecials']])
            ];
            $items[] = [
                'options' => ['id' => 'tabimages'],
                'label' => UsniAdaptor::t('products', 'Images'),
                'content' => $this->render('/detail/_images', ['productImages' => $model['productImages']])
            ];
            echo Tabs::widget(['items' => $items]);
    ?>
</div>