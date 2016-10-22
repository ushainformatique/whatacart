<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\stores\views;

use usni\library\views\UiDetailView;
use usni\library\utils\StatusUtil;
use usni\UsniAdaptor;
use usni\library\views\UiTabbedView;
use usni\library\modules\users\views\UserAddressView;
use common\modules\stores\models\StoreConfiguration;
use usni\library\utils\ArrayUtil;
use common\modules\stores\utils\StoreUtil;
/**
 * StoreDetailView class file
 *
 * @package common\modules\stores\views
 */
class StoreDetailView extends UiDetailView
{

    /**
     * @inheritdoc
     */
    public function getColumns()
    {
        $owner = StoreUtil::getStoreOwner($this->model['owner_id']);
        return [
                    'name',
                    [
                        'attribute' => 'status', 'value' => StatusUtil::renderLabel($this->model), 'format' => 'raw'
                    ],
                    'person.fullName',
                    'metakeywords',
                    'metadescription',
                    [
                        'attribute' => 'data_category_id',
                        'value'     => $this->model->dataCategory->name
                    ],
                    'description',
                    'theme'
               ];
    }

    /**
     * @inheritdoc
     */
    protected function getTitle()
    {
        return $this->model->name;
    }
    
    /**
     * @inheritdoc
     */
    protected function renderContent()
    {
        $content     = null;
        $infoContent = parent::renderContent();
        $shippingAddress      = $this->model->shippingAddress;
        $billingAddress       = $this->model->billingAddress;
        
        //Shipping address view.
        if($shippingAddress != null)
        {
            // Shipping address view
            $shippingViewClass       = UserAddressView::className();
            $shippingViewInstance    = new $shippingViewClass($this->getDetailViewConfiguration($shippingAddress));
            $shippingView            = $shippingViewInstance->render();
        }
        else
        {
            $shippingView = null;
        }
        
        // Billing address view
        if($billingAddress != null)
        {
            //Billing address view
            $billingViewClass       = UserAddressView::className();
            $billingViewInstance    = new $billingViewClass($this->getDetailViewConfiguration($billingAddress));
            $billingView            = $billingViewInstance->render();
        }
        else
        {
            $billingView = null;
        }
        
        //Store local view
        $storeLocal           = StoreConfiguration::find()->where('store_id = :sid AND code = :code', 
                                                                 [':sid' => $this->model->id, ':code' => 'storelocal'])->asArray()->all();
        $storeLocal           = ArrayUtil::map($storeLocal, 'key', 'value');
        if($storeLocal != null)
        {
            $storeLocalView      = StoreLocalView::className();
            $localViewInstance   = new $storeLocalView($this->getDetailViewConfiguration($storeLocal));
            $localView           = $localViewInstance->render();
        }
        else
        {
            $localView = null;
        }
        
        //Store settings view
        $storeSettings           = StoreConfiguration::find()->where('store_id = :sid AND code = :code', 
                                                                    [':sid' => $this->model->id, ':code' => 'storesettings'])->asArray()->all();
        $storeSettings           = ArrayUtil::map($storeSettings, 'key', 'value');
        if(!empty($storeSettings))
        {
            $storeSettingsView     = StoreSettingsView::className();
            $settingsViewInstance  = new $storeSettingsView($this->getDetailViewConfiguration($storeSettings));
            $settingsView          = $settingsViewInstance->render();
        }
        else
        {
            $settingsView = null;
        }
        
        //Store image view
        $storeImage           = StoreConfiguration::find()->where('store_id = :sid AND code = :code', 
                                                                    [':sid' => $this->model->id, ':code' => 'storeimage'])->asArray()->all();
        $storeImage           = ArrayUtil::map($storeImage, 'key', 'value');
        if(!empty($storeImage))
        {
            $storeImageView     = StoreImageView::className();
            $imageViewInstance  = new $storeImageView($this->getDetailViewConfiguration($storeImage));
            $imageView          = $imageViewInstance->render();
        }
        else
        {
            $imageView = null;
        }

        $tabs        = ['storeInfo'    => ['label'    => UsniAdaptor::t('application', 'General'),
                                           'content'  => $infoContent,
                                           'active'   => true],
                        'shippingInfo'  => ['label'   => UsniAdaptor::t('customer', 'Shipping Address'),
                                           'content'  => $shippingView],
                        'billingInfo'   => ['label'   => UsniAdaptor::t('customer', 'Billing Address'),
                                           'content'  => $billingView],
                        'localInfo'     => ['label'   => UsniAdaptor::t('stores', 'Local'),
                                           'content'  => $localView],
                        'settingsInfo'  => ['label'   => UsniAdaptor::t('stores', 'Settings'),
                                            'content'  => $settingsView],
                        'imageInfo'     => ['label'   => UsniAdaptor::t('stores', 'Image'),
                                            'content'  => $imageView]];
        $tabbedView  = new UiTabbedView($tabs);
        $content    .= $tabbedView->render();
        return $content;
    }
    
    /**
     * Get configuration for rendering grid view.
     * @param Model $model
     * @return array
     */
    protected function getDetailViewConfiguration($model)
    {
        return ['model'       => $model,
                'controller'  => $this->controller];
    }
}
?>