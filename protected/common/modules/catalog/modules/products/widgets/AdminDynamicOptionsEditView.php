<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace products\widgets;

use common\utils\ApplicationUtil;
/**
 * AdminDynamicOptionsEditView class file
 *
 * @package products\widgets
 */
class AdminDynamicOptionsEditView extends DynamicOptionsEditView
{
    /**
     * @inheritdoc
     */
    protected function getSelectedCurrency()
    {
        $checkout = ApplicationUtil::getCheckout();
        return $checkout->customerForm->currencyCode;
    }
}