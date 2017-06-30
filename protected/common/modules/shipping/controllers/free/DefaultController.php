<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\shipping\controllers\free;

use usni\UsniAdaptor;
use common\modules\shipping\business\free\Manager;
use yii\web\NotFoundHttpException;
/**
 * DefaultController class file
 *
 * @package common\modules\shipping\controllers\free
 */
class DefaultController extends \usni\library\web\Controller
{
    /**
     * Change status.
     * @param int $id
     * @param int $status
     * @return void
     */
    public function actionChangeStatus($id, $status)
    {
        $result     = Manager::getInstance()->processChangeStatus($id, $status);
        if($result == false)
        {
            throw new NotFoundHttpException();
        }
        return $this->redirect(UsniAdaptor::createUrl('shipping/default/index'));
    }
}