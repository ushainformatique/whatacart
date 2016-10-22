<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\sequence\controllers;

use common\modules\sequence\models\Sequence;
use usni\library\components\UiAdminController;
/**
 * DefaultController class file
 * @package common\modules\sequence\controllers
 */
class DefaultController extends UiAdminController
{
    /**
     * @inheritdoc
     */
    protected function resolveModelClassName()
    {
        return Sequence::className();
    }
}
?>