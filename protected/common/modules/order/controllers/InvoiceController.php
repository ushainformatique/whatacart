<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\order\controllers;

use common\modules\order\models\Invoice;
use usni\UsniAdaptor;
use yii\filters\AccessControl;
use common\modules\order\business\InvoiceManager;
use common\modules\order\dto\InvoiceDetailViewDTO;
use yii\web\ForbiddenHttpException;
/**
 * InvoiceController class file
 * 
 * @package common\modules\order\controllers
 */
class InvoiceController extends \usni\library\web\Controller
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
                        'actions' => ['view'],
                        'roles' => ['order.manage'],
                    ]
                ],
            ],
        ];
    }
    
    /**
     * View invoice
     * @param type $id
     */
    public function actionView($id)
    {
        $detailViewDTO      = new InvoiceDetailViewDTO();
        $detailViewDTO->setId($id);
        $detailViewDTO->setModelClass(Invoice::className());
        $result     = InvoiceManager::getInstance()->processDetail($detailViewDTO);
        if($result === false)
        {
            throw new ForbiddenHttpException(\Yii::t('yii','You are not authorized to perform this action.'));
        }
        //Remove some assets
        UsniAdaptor::app()->assetManager->bundles['usni\library\web\AdminAssetBundle']['css'] = [];
        UsniAdaptor::app()->assetManager->bundles['usni\library\web\AdminAssetBundle']['js'] = [];
        $this->getView()->sidenavView   = null;
        $this->getView()->headerView    = null;
        $this->getView()->footerView    = null;
        echo $this->render('/invoice/view', ['detailViewDTO' => $detailViewDTO]);
    }
}