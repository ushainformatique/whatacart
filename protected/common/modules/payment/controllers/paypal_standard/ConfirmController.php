<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace common\modules\payment\controllers\paypal_standard;

use common\modules\payment\business\paypal_standard\Manager;
/**
 * ConfirmController for the cash on delivery payment method
 *
 * @package common\modules\payment\controllers\paypal_standard
 */
class ConfirmController extends \usni\library\web\Controller
{
    /**
     * Index action for confirm
     * @return string
     */
    public function actionIndex()
    {
        $config                 = Manager::getInstance()->getPaypalConfig();
        return $this->renderPartial('/paypal_standard/confirmorder', ['config' => $config]);
    }
    
    public function actionValidate()
    {
        $config                 = Manager::getInstance()->getPaypalConfig();
        return $this->renderPartial('/paypal_standard/_confirmform', ['config' => $config]);
    }
}
