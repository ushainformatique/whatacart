<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\shipping\controllers\flat;

use usni\UsniAdaptor;
use usni\library\utils\FlashUtil;
use common\modules\shipping\business\flat\Manager;
use common\modules\shipping\dto\FlatShippingFormDTO;
use yii\filters\AccessControl;
/**
 * SettingsController class file
 *
 * @package common\modules\shipping\controllers\flat
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
                    ]
                ],
            ],
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function actionIndex()
    {
        $formDTO = new FlatShippingFormDTO();
        $formDTO->setPostData(UsniAdaptor::app()->request->post());
        Manager::getInstance()->processSettings($formDTO);
        if($formDTO->getIsTransactionSuccess() == true)
        {
            FlashUtil::setMessage('success', UsniAdaptor::t('shipping', 'Flat shipping settings are saved successfully'));
            return $this->refresh();
        }
        else
        {
            return $this->render('/flat/settings', ['formDTO' => $formDTO]);
        }
    }
}