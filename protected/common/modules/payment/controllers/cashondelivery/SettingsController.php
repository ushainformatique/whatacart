<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\payment\controllers\cashondelivery;

use usni\library\components\UiAdminController;
use usni\UsniAdaptor;
use common\modules\payment\models\cashondelivery\CashOnDeliverySetting;
use common\modules\payment\views\cashondelivery\CashOnDeliverySettingsEditView;
use usni\library\utils\FlashUtil;
use common\modules\stores\utils\StoreUtil;
/**
 * SettingsController class file
 *
 * @package common\modules\payment\controllers\cashondelivery
 */
class SettingsController extends UiAdminController
{
    /**
     * @inheritdoc
     */
    public function actionIndex()
    {
        $model = new CashOnDeliverySetting();
        if(isset($_POST['CashOnDeliverySetting']))
        {
            $model->attributes  = $_POST['CashOnDeliverySetting'];
            if($model->validate())
            {
                $currStore = UsniAdaptor::app()->storeManager->getCurrentStore();
                StoreUtil::insertOrUpdateConfiguration('cashondelivery', 'payment', 'order_status', $model->order_status, $currStore->id);
            }
            if(empty($model->errors))
            {
                FlashUtil::setMessage('cashondeliverySettingsSaved', UsniAdaptor::t('payment', 'Settings are saved successfully'));
            }
        }
        else
        {
            $model->attributes  = StoreUtil::getStoreConfgurationAttributesByCodeForStore('cashondelivery', 'payment');
        }
        $breadcrumbs      = [
                                [
                                    'label' => UsniAdaptor::t('payment', 'Manage Payments'),
                                    'url'   => UsniAdaptor::createUrl('payment/default/manage')
                                ],
                                [
                                    'label' => UsniAdaptor::t('payment', 'Cash On Delivery Settings')
                                ]
                            ];
        $this->getView()->params['breadcrumbs']  = $breadcrumbs;
        $view               = new CashOnDeliverySettingsEditView($model);
        $content            = $this->renderColumnContent([$view]);
        return $this->render($this->getDefaultLayout(), ['content' => $content]);
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