<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\localization\modules\orderstatus\traits;

use common\modules\localization\modules\orderstatus\models\OrderStatusTranslated;
use usni\library\utils\ArrayUtil;
use common\modules\localization\modules\orderstatus\dao\OrderStatusDAO;
/**
 * Implement common functions related to order status
 * 
 * @package common\modules\localization\modules\orderstatus\traits
 */
trait OrderStatusTrait
{
    /**
     * Gets label for the status.
     * @param integer $id
     * @return string
     */
    public function getOrderStatusLabel($id)
    {
        $record     = OrderStatusTranslated::find()->where('owner_id = :oid AND language = :language', 
                                                                         [':oid' => $id, ':language' => $this->language])->asArray()->one();
        return $record['name'];
    }
    
    /**
     * Get all order status.
     * @return array
     */
    public function getAllOrderStatus()
    {
        $orderStatus    = OrderStatusTranslated::find()->where('language = :lang', [':lang' => $this->language])->asArray()->all();
        $data           = ArrayUtil::map($orderStatus, 'name', 'owner_id');
        return $data;
    }
    
    /**
     * Get status id
     * @param string $statusLabel
     * @param string $language
     * @return int
     */
    public function getStatusId($statusLabel, $language)
    {
        $record     = OrderStatusTranslated::find()->where('name = :name AND language = :language', 
                                                                         [':name' => $statusLabel, ':language' => $language])->asArray()->one();
        return $record['owner_id'];
    }
    
    /**
     * Get order status dropdown data.
     * @return array
     */
    public function getOrderStatusDropdownData()
    {
        $data = OrderStatusDAO::getAll($this->language);
        return ArrayUtil::map($data, 'id', 'name');
    }
}
