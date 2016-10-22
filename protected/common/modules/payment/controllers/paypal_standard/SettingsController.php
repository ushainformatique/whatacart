<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\payment\controllers\paypal_standard;

use usni\library\components\UiAdminController;
use common\modules\payment\views\paypal_standard\PaypalSettingEditView;
use usni\library\utils\FlashUtil;
use usni\UsniAdaptor;
use common\modules\payment\models\paypal_standard\PaypalSettingForm;
use yii\base\Model;
use common\modules\stores\utils\StoreUtil;
/**
 * SettingsController class file
 *
 * @package common\modules\payment\controllers\paypal_standard
 */
class SettingsController extends UiAdminController
{
    /**
     * @inheritdoc
     */
    public function actionIndex()
    {
        $model = new PaypalSettingForm();
        if(isset($_POST['PaypalSetting']))
        {
            $model->paypalSetting->attributes       = $_POST['PaypalSetting'];
            $model->paypalOrderStatus->attributes   = $_POST['PaypalOrderStatus'];
            if(Model::validateMultiple([$model->paypalSetting, $model->paypalOrderStatus]))
            {
                StoreUtil::processInsertOrUpdateConfiguration($model->paypalSetting, 'paypal_standard', 'payment');
                StoreUtil::processInsertOrUpdateConfiguration($model->paypalOrderStatus, 'paypal_standard_orderstatus_map', 'payment');
            }
            FlashUtil::setMessage('paypalSettingsSaved', UsniAdaptor::t('paypal', 'Paypal settings are saved successfully'));
        }
        else
        {
            $model->paypalSetting->attributes       = StoreUtil::getStoreConfgurationAttributesByCodeForStore('paypal_standard', 'payment');
            $model->paypalOrderStatus->attributes   = StoreUtil::getStoreConfgurationAttributesByCodeForStore('paypal_standard_orderstatus_map', 'payment');
        }
        $breadcrumbs      = [
                                [
                                    'label' => UsniAdaptor::t('payment', 'Manage Payments'),
                                    'url'   => UsniAdaptor::createUrl('payment/default/manage')
                                ],
                                [
                                    'label' => UsniAdaptor::t('payment', 'Paypal Settings')
                                ]
                            ];
        $this->getView()->params['breadcrumbs']  = $breadcrumbs;
        $view               = new PaypalSettingEditView($model);
        $content            = $this->renderColumnContent(array($view));
        return $this->render($this->getDefaultLayout(), array('content' => $content));
    }
    
    /**
     * @inheritdoc
     */
    protected function resolveModelClassName()
    {
        return null;
    }
}
?>