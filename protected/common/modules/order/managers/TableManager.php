<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\order\managers;

use common\modules\order\managers\OrderTableBuilder;
use common\modules\order\managers\OrderAddressDetailsTableBuilder;
use common\modules\order\managers\OrderPaymentDetailsTableBuilder;
use common\modules\order\managers\OrderProductTableBuilder;
use common\modules\order\managers\OrderPaymentTransactionMapTableBuilder;
/**
 * TableManager class file.
 *
 * @package common\modules\order\managers
 */
class TableManager extends \usni\library\components\UiTableManager
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
