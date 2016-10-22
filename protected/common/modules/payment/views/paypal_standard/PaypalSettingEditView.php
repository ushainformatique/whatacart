<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\payment\views\paypal_standard;

use usni\library\extensions\bootstrap\views\UiTabbedEditView;
use usni\library\utils\ButtonsUtil;
use usni\UsniAdaptor;
use usni\library\utils\FlashUtil;
use usni\library\components\UiActiveForm;
/**
 * PaypalSettingEditView class file
 *
 * @package common\modules\payment\views\paypal_standard
 */
class PaypalSettingEditView extends UiTabbedEditView
{
    /**
     * @inheritdoc
     */
    public function getFormBuilderMetadata()
    {
        $paypalSettingView     = $this->renderSubView(PaypalSettingEditSubView::className(), $this->model->paypalSetting);
        $orderStatusView       = $this->renderSubView(PaypalOrderStatusEditView::className(), $this->model->paypalOrderStatus);
        $elements               = [
                                    'paypalSetting'     => ['type' => UiActiveForm::INPUT_RAW, 'value' => $paypalSettingView],
                                    'orderStatusView'   => ['type' => UiActiveForm::INPUT_RAW, 'value' => $orderStatusView]
                                  ];
        $metadata               = [
                                     'elements'         => $elements,
                                     'buttons'          => ButtonsUtil::getDefaultButtonsMetadata('payment/default/manage')
                                  ];
        return $metadata;
    }
    
    /**
     * @inheritdoc
     */
    protected function renderTitle()
    {
        return UsniAdaptor::t('payment', 'Paypal Settings');
    }
    
    /**
     * @inheritdoc
     */
    protected function renderFlashMessages()
    {
        return FlashUtil::render('paypalSettingsSaved');
    }
    
    /**
     * @inheritdoc
     */
    protected function renderEditModeBrowseView()
    {
        return null;
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
                     'paypalSetting'      => ['label'   => UsniAdaptor::t('payment', 'Paypal Settings'),
                                              'content' => $this->renderTabElements('paypalSetting')],
                     'orderStatusView'    => ['label'   => UsniAdaptor::t('orderstatus', 'Order Status'),
                                              'content' => $this->renderTabElements('orderStatusView')],
                                             
               ];
    }

    /**
     * @inheritdoc
     */
    protected function getTabElementsMap()
    {
        return [
                    'paypalSetting'      => ['paypalSetting'],
                    'orderStatusView'    => ['orderStatusView']
               ];
    }
}
?>