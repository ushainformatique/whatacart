<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\payment\managers;

//use common\modules\payment\managers\PaymentTableBuilder;
use common\modules\payment\managers\cashondelivery\CashOnDeliveryTransactionTableBuilder;
use common\modules\payment\managers\paypal_standard\PaypalStandardTransactionTableBuilder;
/**
 * TableManager class file.
 * @package common\modules\payment\managers
 */
class TableManager extends \usni\library\components\UiTableManager
{
    /**
     * @inheritdoc
     */
    protected static function getTableBuilderConfig()
    {
        return [
                   //PaymentTableBuilder::className(),
                   CashOnDeliveryTransactionTableBuilder::className(),
                   PaypalStandardTransactionTableBuilder::className()
               ];
    }
}
