<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\payment\views\cashondelivery;

use usni\UsniAdaptor;
use common\modules\order\utils\OrderUtil;
/**
 * AddPaymentView class file.
 *
 * @package common\modules\payment\views\cashondelivery
 */
class AddPaymentView extends \common\modules\payment\views\BaseAddPaymentView
{
    /**
     * @inheritdoc
     */
    public function getFormBuilderMetadata()
    {
        $this->model->transaction_id    = OrderUtil::getUniqueTransactionId($this->model->tableName());
        $this->model->transaction_fee   = 0;
        return parent::getFormBuilderMetadata();
    }
    
    /**
     * @inheritdoc
     */
    protected function renderTitle()
    {
        return UsniAdaptor::t('payment', 'Cash Details');
    }
    
    /**
     * @inheritdoc
     */
    protected function attributeOptions()
    {
        $attributeOptions = parent::attributeOptions();
        $attributeOptions['transaction_id']     = ['inputOptions' => ['readonly' => true]];
        $attributeOptions['transaction_fee']    = ['inputOptions' => ['readonly' => true]];
        return $attributeOptions;
    }
}