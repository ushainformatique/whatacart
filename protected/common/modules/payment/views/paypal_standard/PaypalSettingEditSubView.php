<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\payment\views\paypal_standard;

use common\modules\payment\utils\paypal_standard\PaypalUtil;
/**
 * PaypalSettingEditSubView class file
 *
 * @package common\modules\payment\views\paypal_standard
 */
class PaypalSettingEditSubView extends \usni\library\views\MultiModelEditView
{
    /**
     * @inheritdoc
     */
    public function getFormBuilderMetadata()
    {
        $data     = PaypalUtil::getTransactionType();
        $elements = [
                        'business_email'=> ['type' => 'text'],
                        'return_url'    => ['type' => 'text'],
                        'cancel_url'    => ['type' => 'text'],
                        'notify_url'    => ['type' => 'text'],
                        'transactionType' => ['type' => 'dropdownList', 'items' => $data],
                        'sandbox'       => ['type' => 'checkbox'],
                    ];
        $metadata = [
                        'elements'   => $elements,
                    ];
        return $metadata;
    }
    
    /**
     * @inheritdoc
     */
    protected function attributeOptions()
    {
        return array(
            'sandbox' => array(
                    'options' => [],
                    'horizontalCheckboxTemplate' => "<div class=\"checkbox checkbox-admin\">\n{beginLabel}\n{input}\n{labelTitle}\n{endLabel}\n</div>\n{error}"
            )
        );
    }
    
    /**
     * @inheritdoc
     */
    protected function renderEditModeBrowseView()
    {
        return null;
    }
}
?>