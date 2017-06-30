<?php 
namespace common\modules\order\models;
    
use usni\library\db\ActiveRecord;
/**
 * InvoiceTranslated class file
 * 
 * @package common\modules\order\models
 */
class InvoiceTranslated extends ActiveRecord
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