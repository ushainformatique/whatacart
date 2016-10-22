<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\shipping\controllers\flat;

use usni\library\components\UiBaseController;
use usni\UsniAdaptor;
use common\modules\shipping\models\flat\FlatRateEditForm;
use common\modules\shipping\utils\flat\FlatShippingUtil;
use common\modules\shipping\views\flat\FlatRateShippingEditView;
use common\modules\stores\utils\StoreUtil;
use usni\library\utils\FlashUtil;
/**
 * SettingsController class file
 *
 * @package common\modules\shipping\controllers\flat
 */
class SettingsController extends UiBaseController
{
    /**
     * @inheritdoc
     */
    public function actionIndex()
    {
        $model              = new FlatRateEditForm();
        $postData           = UsniAdaptor::app()->request->post();
        if ($model->load($postData))
        {
            if($model->applicableZones == FlatShippingUtil::SHIP_TO_ALL_ZONES)
            {
                $model->specificZones = [];
            }
            $model->specificZones = serialize($model->specificZones);
            StoreUtil::processInsertOrUpdateConfiguration($model, 'flat', 'shipping');
            FlashUtil::setMessage('flatShippingSettingsSaved', UsniAdaptor::t('paypal', 'Flat shipping settings are saved successfully'));
            //Unserialize
            $model->specificZones = unserialize($model->specificZones);
        }
        else
        {
            $model->attributes    = StoreUtil::getStoreConfgurationAttributesByCodeForStore('flat', 'shipping');
            $model->specificZones = unserialize($model->specificZones);
        }
        $breadcrumbs      = [
                                [
                                    'label' => UsniAdaptor::t('shipping', 'Manage Shipping'),
                                    'url'   => UsniAdaptor::createUrl('shipping/default/manage')
                                ],
                                [
                                    'label' => UsniAdaptor::t('shipping', 'Flat Rate Settings')
                                ]
                            ];
        $this->getView()->params['breadcrumbs']  = $breadcrumbs;
        $shippingView       = FlatRateShippingEditView::className();
        $view               = new $shippingView($model);
        $content            = $this->renderColumnContent([$view]);
        return $this->render('@usni/themes/bootstrap/views/layouts/main', ['content' => $content]);
    }
}
?>