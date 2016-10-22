<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace cart\views;

use frontend\utils\FrontUtil;
use usni\library\utils\FileUtil;
use usni\UsniAdaptor;
use common\modules\payment\utils\PaymentUtil;
/**
 * PaymentMethodEditView class file.
 * 
 * @package cart\views
 */
class PaymentMethodEditView extends \usni\library\views\MultiModelEditView
{
    /**
     * Application end into which view is loaded
     * @var string 
     */
    public $source;
    
    /**
     * @inheritdoc
     */
    public function getFormBuilderMetadata()
    {
        $paymentMethods = $this->getPaymentMethods();
        if($this->model->payment_method == null)
        {
            $keys = array_keys($paymentMethods);
            $this->model->payment_method = $keys[0];
        }
        $elements = [
                        'payment_method' => ['type' => 'radioList', 'items' => $paymentMethods]
                    ];
        if($this->source == 'front')
        {
            $elements['agree'] = array('type' => 'checkbox');
        }
        else
        {
            $elements['agree'] = array('type' => 'hidden', 'value' => 1);
        }
        $metadata = [
                        'elements'              => $elements,
                    ];
        return $metadata;
    }
    
    /**
     * @inheritdoc
     */
    protected function attributeOptions()
    {
        return [
            'payment_method' => ['template' => "{beginWrapper}\n{input}\n{error}\n{endWrapper}"],
            'agree' => array(
                    'options' => [],
                    'checkboxTemplate' => "<div class=\"checkbox\">\n{beginLabel}\n{input}\n{labelTitle}\n" . ' <a href="#termsModal" data-toggle="modal">' .  UsniAdaptor::t('application', 'Terms and Conditions') . '</a>' . "{endLabel}\n</div>\n{error}"
            )
        ];
    }
    
    /**
     * @inheritdoc
     */
    protected function renderContent()
    {
        $themeName      = FrontUtil::getThemeName();
        $path           = FileUtil::normalizePath(APPLICATION_PATH . '/themes/' . $themeName . '/views/cart/_termsmodal.php');
        $modalContent   = UsniAdaptor::app()->getView()->renderPhpFile($path, []);
        return parent::renderContent() . $modalContent;
    }
    
    /**
     * Get payment methods
     * @return array
     */
    protected function getPaymentMethods()
    {
        return PaymentUtil::getPaymentMethodDropdown();
    }
}