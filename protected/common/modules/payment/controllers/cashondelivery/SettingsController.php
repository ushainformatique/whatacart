<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\payment\controllers\cashondelivery;

use usni\UsniAdaptor;
use usni\library\utils\FlashUtil;
use common\modules\payment\dto\CashOnDeliveryFormDTO;
use common\modules\payment\business\cashondelivery\Manager;
use usni\library\utils\ArrayUtil;
use yii\filters\AccessControl;
/**
 * SettingsController class file
 *
 * @package common\modules\payment\controllers\cashondelivery
 */
class SettingsController extends \usni\library\web\Controller
{
    /**
     * inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index'],
                        'roles' => ['extension.manage'],
                    ],
                ],
            ],
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function actionIndex()
    {
        $formDTO    = new CashOnDeliveryFormDTO();
        $postData   = ArrayUtil::getValue($_POST, ['CashOnDeliverySetting']);
        $formDTO->setPostData($postData);
        Manager::getInstance()->processSettings($formDTO);
        if($formDTO->getIsTransactionSuccess() === true)
        {
            FlashUtil::setMessage('success', UsniAdaptor::t('paymentflash', 'Settings are saved successfully.'));
            return $this->refresh();
        }
        else
        {
            return $this->render('/cashondelivery/settings', ['formDTO' => $formDTO]);
        }
    }
}