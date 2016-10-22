<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\stores\views;

use usni\library\extensions\bootstrap\views\UiTabbedEditView;
use usni\library\utils\ButtonsUtil;
use usni\library\components\UiActiveForm;
use usni\UsniAdaptor;
use common\modules\stores\views\StoreEditSubView;
use usni\library\modules\users\views\AddressEditView;
use common\models\BillingAddress;
use common\models\ShippingAddress;
use common\modules\stores\views\StoreLocalEditView;
use common\modules\stores\models\StoreLocal;
use common\modules\stores\views\StoreSettingsEditView;
use common\modules\stores\models\StoreSettings;
use common\modules\stores\views\StoreImageEditView;
use common\modules\stores\models\StoreImage;
use common\modules\stores\utils\StoreUtil;
use usni\library\utils\ArrayUtil;
/**
 * StoreEditView class file
 *
 * @package common\modules\stores\views
 */
class StoreEditView extends UiTabbedEditView
{
    /**
     * @inheritdoc
     */
    public function getFormBuilderMetadata()
    {
        $storeView              = $this->renderSubView(StoreEditSubView::className(), $this->model->store);
        $billingAddressView     = $this->renderSubView(AddressEditView::className(), $this->model->billingAddress);
        $shippingAddressView    = $this->renderSubView(ShippingAddressEditView::className(), $this->model->shippingAddress);
        $localEditView          = $this->renderSubView(StoreLocalEditView::className(), $this->model->storeLocal);
        $storeSettingEditView   = $this->renderSubView(StoreSettingsEditView::className(), $this->model->storeSettings);
        $storeImageEditView     = $this->renderSubView(StoreImageEditView::className(), $this->model->storeImage);
        $elements               = [
                                    'store'             => ['type' => UiActiveForm::INPUT_RAW, 'value' => $storeView],
                                    'billingAddress'    => ['type' => UiActiveForm::INPUT_RAW, 'value' => $billingAddressView],
                                    'shippingAddress'   => ['type' => UiActiveForm::INPUT_RAW, 'value' => $shippingAddressView],
                                    'local'             => ['type' => UiActiveForm::INPUT_RAW, 'value' => $localEditView],
                                    'settings'          => ['type' => UiActiveForm::INPUT_RAW, 'value' => $storeSettingEditView],
                                    'image'             => ['type' => UiActiveForm::INPUT_RAW, 'value' => $storeImageEditView]
                                  ];
        $metadata               = [
                                     'elements'         => $elements,
                                     'buttons'          => ButtonsUtil::getDefaultButtonsMetadata("stores/default/manage")
                                  ];
        return $metadata;
    }

    /**
     * @inheritdoc
     */
    protected function renderEditModeBrowseView()
    {
        if($this->model->scenario == 'update')
        {
            $store          = $this->model->store;
            $viewClassName  = static::resolveBrowseModelViewClassName();
            $view           = new $viewClassName(['model'       => $store, 
                                                  'attribute'   => $this->resolveDefaultBrowseByAttribute(), 
                                                  'shouldRenderOwnerCreatedModelsForBrowse' => $this->shouldRenderOwnerCreatedModels()]);
            return $view->render();
        }
    }
    
    /**
     * @inheritdoc
     */
    protected function renderSubView($viewClassName, $model)
    {
        //Passing form as we have removed renderBegin from sub view that $this->form is null for the sub views
        $view = new $viewClassName(['model' => $model, 'form' => $this->form]);
        return $view->render();
    }
    
    /**
     * @inheritdoc
     */
    protected function getTabs()
    {
        return [     
                     'store'             => ['label'   => UsniAdaptor::t('application', 'General'),
                                            'content' => $this->renderTabElements('store')],
                     'billingAddress'    => ['label'   => BillingAddress::getLabel(1),
                                             'content' => $this->renderTabElements('billingAddress')],
                     'shippingAddress'   => ['label'   => ShippingAddress::getLabel(1),
                                             'content' => $this->renderTabElements('shippingAddress')],
                     'local'             => ['label'   => StoreLocal::getLabel(1),
                                             'content' => $this->renderTabElements('local')],
                     'settings'          => ['label'   => StoreSettings::getLabel(1),
                                             'content' => $this->renderTabElements('settings')],
                     'image'             => ['label'   => StoreImage::getLabel(1),
                                             'content' => $this->renderTabElements('image')],         
               ];
    }

    /**
     * @inheritdoc
     */
    protected function getTabElementsMap()
    {
        return [
                    'store'             => ['store'],
                    'billingAddress'    => ['billingAddress'],
                    'shippingAddress'   => ['shippingAddress'],
                    'local'             => ['local'],
                    'settings'          => ['settings'],
                    'image'             => ['image']
               ];
    }
    
    /**
     * @inheritdoc
     */
    protected function renderTitle()
    {
        if($this->model->scenario == 'create')
        {
            return UsniAdaptor::t('application', 'Create') . ' ' . UsniAdaptor::t('stores', 'Store');
        }
        elseif($this->model->scenario == 'update')
        {
            return UsniAdaptor::t('application', 'Update') . ' ' . UsniAdaptor::t('stores', 'Store');
        }
    }
    
    /**
     * @inheritdoc
     */
    public function isMultiPartFormData()
    {
        return true;
    }
    
    /**
     * @inheritdoc
     */
    protected function registerScripts()
    {
        parent::registerScripts();
        StoreUtil::registerSameAsBillingAddressScript($this->getView());
    }
    
    /**
     * @inheritdoc
     */
    public function renderErrorSummary()
    {
        $errors = $this->getModelErrors();
        $this->model->addErrors($errors);
        return $this->form->errorSummary($this->model, ['class' => 'alert alert-danger']);
    }
    
    /**
     * Get model errors
     * @return array
     */
    protected function getModelErrors()
    {
        return ArrayUtil::merge($this->model->store->getErrors(), 
                                $this->model->billingAddress->getErrors(), 
                                $this->model->shippingAddress->getErrors(),
                                $this->model->storeLocal->getErrors(),
                                $this->model->storeSettings->getErrors(),
                                $this->model->storeImage->getErrors());
    }
}
?>