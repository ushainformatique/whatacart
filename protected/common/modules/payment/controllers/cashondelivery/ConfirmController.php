<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace common\modules\payment\controllers\cashondelivery;
/**
 * ConfirmController for the cash on delivery payment method
 *
 * @package common\modules\payment\controllers\cashondelivery
 */
class ConfirmController extends \usni\library\web\Controller
{
    /**
     * Index action for confirm
     * @return string
     */
    public function actionIndex()
    {
        return $this->renderPartial('/cashondelivery/confirmorder');
    }
}
