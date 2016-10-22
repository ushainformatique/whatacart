<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace common\modules\enhancement\controllers;

use common\modules\extension\models\Extension;
use common\modules\extension\models\ExtensionSearch;
use common\modules\enhancement\views\EnhancementGridView;
use usni\UsniAdaptor;
/**
 * DefaultController class file
 *
 * @package common\modules\enhancement\controllers
 */
class DefaultController extends \usni\library\components\UiAdminController
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
        $extensions = Extension::findOne($id);
        $extensions->status = $status;
        $extensions->save();
        return $this->renderGridView();
    }
    
    /**
     * @inheritdoc
     */
    protected function getFilterModel($model)
    {
        $filterModel = new ExtensionSearch();
        $filterModel->load($_GET, 'ExtensionSearch');
        $filterModel->category = 'enhancement';
        return $filterModel;
    }
    
    /**
     * @inheritdoc
     */
    protected function resolveGridViewClassName($model)
    {
        return EnhancementGridView::className();
    }
    
    /**
     * @inheritdoc
     */
    public function getGridViewBreadcrumb($model)
    {
        return [
            [
                'label' => UsniAdaptor::t('application', 'Manage') . ' ' . UsniAdaptor::t('enhancement', 'Enhancements')
            ]
        ];
    }
}
?>