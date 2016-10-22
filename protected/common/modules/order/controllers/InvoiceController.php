<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\order\controllers;

use usni\library\components\UiAdminController;
use common\modules\order\models\Invoice;
use usni\UsniAdaptor;
/**
 * InvoiceController class file
 * @package common\modules\order\controllers
 */
class InvoiceController extends UiAdminController
{
    /**
     * @inheritdoc
     */
    protected function resolveModelClassName()
    {
        return Invoice::className();
    }
    
    /**
     * View invoice
     * @param type $id
     */
    public function actionView($id)
    {
        $breadcrumbs    = [
                                [
                                    'label' => UsniAdaptor::t('payment', 'Invoice Details') 
                                ]
                            ];
        $this->getView()->params['breadcrumbs']  = $breadcrumbs;
        $viewHelper  = UsniAdaptor::app()->getModule('order')->viewHelper;
        $invoiceView = $viewHelper->getInstance('invoiceView', ['invoiceId' => $id]);
        //Remove some assets
        UsniAdaptor::app()->assetManager->bundles['usni\library\assets\UiAdminAssetBundle']['css'] = [];
        UsniAdaptor::app()->assetManager->bundles['usni\library\assets\UiAdminAssetBundle']['js'] = [];
        return $this->render($this->getDefaultLayout(), ['content' => $invoiceView->render()]);
    }
    
    /**
     * @inheritdoc
     */
    public function pageTitles()
    {
        return [
                    'view'  => UsniAdaptor::t('application','View') . ' ' . Invoice::getLabel(1),
               ];
    }
    
    /**
     * @inheritdoc
     */
    protected function getActionToPermissionsMap()
    {
        $permissionsMap                 = parent::getActionToPermissionsMap();
        $permissionsMap['view']         = 'order.manage';
        return $permissionsMap;
    }
}
?>