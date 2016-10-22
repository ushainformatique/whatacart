<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\payment\views\paypal_standard;

use usni\library\components\UiHtml;
use usni\library\utils\DAOUtil;
use common\modules\localization\modules\orderstatus\models\OrderStatus;
/**
 * PaypalOrderStatusEditView class file.
 *
 * @package common\modules\payment\views\paypal_standard
 */
class PaypalOrderStatusEditView extends \usni\library\views\MultiModelEditView
{
    /**
     * @inheritdoc
     */
    public function getFormBuilderMetadata()
    {
        $dropdownData = DAOUtil::getDropdownDataBasedOnModel(OrderStatus::className());
        $elements = [
                        'canceled_reversal_status'  => UiHtml::getFormSelectFieldOptions($dropdownData),
                        'completed_status'  => UiHtml::getFormSelectFieldOptions($dropdownData),
                        'denied_status'     => UiHtml::getFormSelectFieldOptions($dropdownData),
                        'expired_status'    => UiHtml::getFormSelectFieldOptions($dropdownData),
                        'failed_status'     => UiHtml::getFormSelectFieldOptions($dropdownData),
                        'pending_status'    => UiHtml::getFormSelectFieldOptions($dropdownData),
                        'processed_status'  => UiHtml::getFormSelectFieldOptions($dropdownData),
                        'refunded_status'   => UiHtml::getFormSelectFieldOptions($dropdownData),
                        'reversed_status'   => UiHtml::getFormSelectFieldOptions($dropdownData),
                        'voided_status'     => UiHtml::getFormSelectFieldOptions($dropdownData),
                    ];
        $metadata = [
                        'elements'  => $elements,
                    ];
        return $metadata;
    }
}
?>