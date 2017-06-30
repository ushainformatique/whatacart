<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace common\modules\payment\controllers\paypal_standard;

use common\modules\payment\models\paypal_standard\PaypalStandardTransaction;
/**
 * TransactionController class file.
 * 
 * @package common\modules\payment\controllers\paypal_standard
 */
class TransactionController extends \common\modules\payment\controllers\BaseTransactionController
{
    /**
     * @inheritdoc
     */
    protected function getType()
    {
        return 'paypal_standard';
    }
    
    /**
     * @inheritdoc
     */
    protected function resolveModelClassName()
    {
        return PaypalStandardTransaction::className();
    }
}