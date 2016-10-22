<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace common\modules\payment\controllers\cashondelivery;

use common\modules\payment\models\cashondelivery\CashOnDeliveryTransaction;
use usni\UsniAdaptor;
/**
 * TransactionController class file.
 * 
 * @package common\modules\payment\controllers\cashondelivery
 */
class TransactionController extends \common\modules\payment\controllers\BaseTransactionController
{
    /**
     * @inheritdoc
     */
    protected function getType()
    {
        return 'cashondelivery';
    }
    
    /**
     * @inheritdoc
     */
    protected function resolveModelClassName()
    {
        return CashOnDeliveryTransaction::className();
    }
    
    /**
     * @inheritdoc
     */
    public function pageTitles()
    {
        return [
                    'add'   => UsniAdaptor::t('payment','Add Payment'),
               ];
    }
}