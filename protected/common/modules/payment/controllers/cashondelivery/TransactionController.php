<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace common\modules\payment\controllers\cashondelivery;

use common\modules\payment\models\cashondelivery\CashOnDeliveryTransaction;
use common\modules\payment\dto\TransactionFormDTO;
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
     * inheritdoc
     * @param TransactionFormDTO $formDTO
     */
    public function populateDTOByType($formDTO)
    {
        parent::populateDTOByType($formDTO);
        $transactionId = $this->getUniqueTransactionId(CashOnDeliveryTransaction::tableName());
        $formDTO->getModel()->transaction_id    = $transactionId;
        $formDTO->getModel()->transaction_fee   = 0;
    }
}