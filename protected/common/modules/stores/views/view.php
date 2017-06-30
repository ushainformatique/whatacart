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

/* @var $detailViewDTO \usni\library\dto\DetailViewDTO */
/* @var $this \usni\library\web\AdminView */

$model          = $detailViewDTO->getModel();
$this->title    = UsniAdaptor::t('application', 'View') . ' ' . UsniAdaptor::t('stores', 'Store');
$this->params['breadcrumbs'] =  [
                                    [
                                        'label' => UsniAdaptor::t('application', 'Manage') . ' ' .
                                        UsniAdaptor::t('stores', 'Stores'),
                                        'url' => ['/stores/default/index']
                                    ],
                                    [
                                        'label' => UsniAdaptor::t('application', 'View') . ' #' . $model['id']
                                    ]
                                ];

$browseParams   = ['permission' => 'stores.viewother',
                   'model' => $model,
                   'data'  => $detailViewDTO->getBrowseModels(),
                   'modalDisplay' => $detailViewDTO->getModalDisplay()];

echo DetailBrowseDropdown::widget($browseParams);
$toolbarParams  = ['editUrl'            => UsniAdaptor::createUrl('stores/default/update', ['id' => $model['id']]),
                   'deleteUrl'          => UsniAdaptor::createUrl('stores/default/delete', ['id' => $model['id']])];
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
                'content' => $this->render('/_storeview', ['detailViewDTO' => $detailViewDTO])
            ];
            $items[] = [
                'options' => ['id' => 'tablocal'],
                'label' => UsniAdaptor::t('stores', 'Local'),
                'content' => $this->render('/_localview', ['detailViewDTO' => $detailViewDTO])
            ];
            $items[] = [
                'options' => ['id' => 'tabbillingaddress'],
                'label' => UsniAdaptor::t('application', 'Billing Address'),
                'content' => $this->render('/_addressview', ['detailViewDTO' => $detailViewDTO, 'addressType' => 'billing'])
            ];
            $items[] = [
                'options' => ['id' => 'tabshippingaddress'],
                'label' => UsniAdaptor::t('application', 'Shipping Address'),
                'content' => $this->render('/_addressview', ['detailViewDTO' => $detailViewDTO, 'addressType' => 'shipping'])
            ];
            $items[] = [
                'options' => ['id' => 'tabsettings'],
                'label' => UsniAdaptor::t('stores', 'Settings'),
                'content' => $this->render('/_settingsview', ['detailViewDTO' => $detailViewDTO])
            ];
            $items[] = [
                'options' => ['id' => 'tabimage'],
                'label' => UsniAdaptor::t('stores', 'Image'),
                'content' => $this->render('/_imageview', ['detailViewDTO' => $detailViewDTO])
            ];
            echo Tabs::widget(['items' => $items]);
    ?>
</div>