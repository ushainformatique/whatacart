<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\payment\controllers\paypal_standard;

use usni\library\utils\FlashUtil;
use usni\UsniAdaptor;
use common\modules\payment\dto\PaypalStandardFormDTO;
use common\modules\payment\business\paypal_standard\Manager;
use yii\filters\AccessControl;
/**
 * SettingsController class file
 *
 * @package common\modules\payment\controllers\paypal_standard
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
        $formDTO    = new PaypalStandardFormDTO();
        $formDTO->setPostData(UsniAdaptor::app()->request->post());
        $manager    = new Manager();
        $manager->processSettings($formDTO);
        if($formDTO->getIsTransactionSuccess() == true)
        {
            FlashUtil::setMessage('success', UsniAdaptor::t('paypal', 'Paypal settings are saved successfully'));
            return $this->refresh();
        }
        else
        {
            return $this->render('/paypal_standard/settings', ['formDTO' => $formDTO]);
        }
    }
}