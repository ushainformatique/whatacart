<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\shipping\controllers\free;

use usni\library\components\UiBaseController;
use usni\UsniAdaptor;
/**
 * SettingsController class file
 *
 * @package common\modules\shipping\controllers\free
 */
class SettingsController extends UiBaseController
{
    /**
     * @inheritdoc
     */
    public function actionIndex()
    {
        return $this->redirect(UsniAdaptor::createUrl('shipping/default/manage'));
    }
}
?>