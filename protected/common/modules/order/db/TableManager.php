<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\order\db;

use common\modules\order\db\OrderTableBuilder;
use common\modules\order\db\OrderAddressDetailsTableBuilder;
use common\modules\order\db\OrderPaymentDetailsTableBuilder;
use common\modules\order\db\OrderProductTableBuilder;
use common\modules\order\db\OrderPaymentTransactionMapTableBuilder;
/**
 * TableManager class file.
 *
 * @package common\modules\order\db
 */
class TableManager extends \usni\library\db\TableManager
{
    /**
     * @inheritdoc
     */
    protected static function getTableBuilderConfig()
    {
        return [
                   OrderTableBuilder::className(),
                   OrderAddressDetailsTableBuilder::className(),
                   OrderPaymentDetailsTableBuilder::className(),
                   OrderProductTableBuilder::className(),
                   InvoiceTableBuilder::className(),
                   OrderPaymentTransactionMapTableBuilder::className(),
                   OrderHistoryTableBuilder::className()
               ];
    }
}
