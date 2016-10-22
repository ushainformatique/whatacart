<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\payment\views\paypal_standard;

use common\utils\ApplicationUtil;
use common\modules\payment\utils\paypal_standard\PaypalUtil;
use common\modules\payment\components\paypal_standard\Paypal;
use cart\views\ConfirmOrderView as BaseView;
use usni\library\components\UiHtml;
/**
 * ConfirmOrderView class file.
 *
 * @package common\modules\payment\views\paypal_standard
 */
class ConfirmOrderView extends BaseView
{
    /**
     * @inheritdoc
     */
    public static function getAction()
    {
        $config = PaypalUtil::getPaypalConfig();
        return $config['paypalUrl'];
    }
    
    /**
     * @inheritdoc
     */
    protected function getFormVariables()
    {
        $config         = PaypalUtil::getPaypalConfig();
        $paypalManager  = new Paypal($config);
        PaypalUtil::setFormVariables(ApplicationUtil::getCart(), ApplicationUtil::getCheckout(), $paypalManager);
        $hiddenVariables = null;
        foreach ($paypalManager->fields as $name => $value)
        {
            $hiddenVariables .= "<input type=\"hidden\" name=\"$name\" value=\"$value\">";
        }
        if($config['businessEmail'] == null)
        {
            $hiddenVariables .= UiHtml::tag('div', 'Business email is missing for the payment gateway. You could not proceed with the order processing.', ['class' => 'alert alert-danger']);
        }
        elseif($config['paypalSandbox'] == true)
        {
            $hiddenVariables .= UiHtml::tag('div', 'The payment gateway is currently in sandbox mode. You would not be charged for the transaction.', ['class' => 'alert alert-warning']);
        }
        return $hiddenVariables;
    }
    
    /**
     * @inheritdoc
     */
    protected function getSubmitButton()
    {
        $config         = PaypalUtil::getPaypalConfig();
        if($config['businessEmail'] == null)
        {
            return null;
        }
        return parent::getSubmitButton();
    }
}