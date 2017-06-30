<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\shipping\controllers\free;

use usni\UsniAdaptor;
use common\modules\extension\models\Extension;
/**
 * SettingsController class file
 *
 * @package common\modules\shipping\controllers\free
 */
class SettingsController extends \usni\library\web\Controller
{
    /**
     * @inheritdoc
     */
    public function actionIndex()
    {
        return $this->redirect(UsniAdaptor::createUrl('shipping/default/index'));
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
        return $this->redirect(UsniAdaptor::createUrl('shipping/default/manage'));
    }
}