<?php 
namespace common\modules\order\models;
    
use usni\library\components\UiSecuredActiveRecord;
/**
 * InvoiceTranslated class file
 * @package common\modules\order\models
 */
class InvoiceTranslated extends UiSecuredActiveRecord
{
    /**
     * @inheritdoc
     */
    public function getInvoice()
    {
        return $this->hasOne(Invoice::className(), ['id' => 'owner_id']);
    }
}
?>