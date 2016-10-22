<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\payment\views\paypal_standard;

use usni\UsniAdaptor;
/**
 * AddPaymentView class file.
 *
 * @package common\modules\payment\views\paypal_standard
 */
class AddPaymentView extends \common\modules\payment\views\BaseAddPaymentView
{
    /**
     * @inheritdoc
     */
    protected function renderTitle()
    {
        return UsniAdaptor::t('payment', 'Paypal Standard');
    }
}
?>