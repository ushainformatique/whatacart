<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\shipping\controllers;

use usni\library\components\UiAdminController;
use usni\UsniAdaptor;
use common\modules\extension\models\Extension;
use common\modules\extension\models\ExtensionSearch;
use common\modules\shipping\views\ShippingGridView;
/**
 * DefaultController class file
 * @package common\modules\shipping\controllers
 */
class DefaultController extends UiAdminController
{
    /**
     * @inheritdoc
     */
    protected function resolveModelClassName()
    {
        return Extension::className();
    }
    
    /**
     * Change status.
     * @param int $id
     * @param int $status
     * @return void
     */
    public function actionChangeStatus($id, $status)
    {
        $extension = Extension::findOne($id);
        $extension->status = $status;
        $extension->save();
        return $this->renderGridView();
    }
    
    /**
     * @inheritdoc
     */
    protected function getFilterModel($model)
    {
        $filterModel = new ExtensionSearch();
        $filterModel->load($_GET, 'ExtensionSearch');
        $filterModel->category = 'shipping';
        return $filterModel;
    }
    
    /**
     * @inheritdoc
     */
    protected function resolveGridViewClassName($model)
    {
        return ShippingGridView::className();
    }
    
    /**
     * @inheritdoc
     */
    public function getGridViewBreadcrumb($model)
    {
        return [
            [
                'label' => UsniAdaptor::t('application', 'Manage') . ' ' . UsniAdaptor::t('shipping', 'Shipping')
            ]
        ];
    }
}
?>