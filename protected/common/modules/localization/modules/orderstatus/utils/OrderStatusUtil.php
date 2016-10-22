<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\localization\modules\orderstatus\utils;

use usni\UsniAdaptor;
use usni\library\extensions\bootstrap\widgets\UiLabel;
use usni\library\components\UiHtml;
use common\modules\localization\modules\orderstatus\models\OrderStatusTranslated;
use usni\library\utils\ArrayUtil;
use common\modules\order\utils\OrderUtil;
/**
 * OrderStatusUtil class file.
 * 
 * @package common\modules\order\utils
 */
class OrderStatusUtil
{
    /**
     * Renders label for the status.
     * @param ActiveRecord $data
     * @return string
     */
    public static function renderLabel($data)
    {
        $value      = static::getLabel($data['status']);
        $id         = 'order-status-' . $data['id'];
        return static::getLabelWidget($value, $id);
    }
    
    /**
     * Get label widget
     * @param string $value
     * @param string $id
     * @return string
     */
    public static function getLabelWidget($value, $id)
    {
        $labelWidget = null;
        if ($value == UsniAdaptor::t('order', 'Completed'))
        {
            $labelWidget = UiLabel::widget(['content' => $value, 'modifier' => UiHtml::COLOR_SUCCESS, 'id' => $id]);
        }
        elseif ($value == UsniAdaptor::t('order', 'Pending'))
        {
            $labelWidget = UiLabel::widget(['content' => $value, 'modifier' => UiHtml::COLOR_DEFAULT, 'id' => $id]);
        }
        elseif ($value == UsniAdaptor::t('order', 'Cancelled'))
        {
            $labelWidget = UiLabel::widget(['content' => $value, 'modifier' => UiHtml::COLOR_DANGER, 'id' => $id]);
        }
        elseif ($value == UsniAdaptor::t('order', 'Cancelled Reversal'))
        {
            $labelWidget = UiLabel::widget(['content' => $value, 'modifier' => UiHtml::COLOR_DEFAULT, 'id' => $id]);
        }
        elseif ($value == UsniAdaptor::t('order', 'Chargeback'))
        {
            $labelWidget = UiLabel::widget(['content' => $value, 'modifier' => UiHtml::COLOR_DEFAULT, 'id' => $id]);
        }
        elseif ($value == UsniAdaptor::t('order', 'Denied'))
        {
            $labelWidget = UiLabel::widget(['content' => $value, 'modifier' => UiHtml::COLOR_DEFAULT, 'id' => $id]);
        }
        elseif ($value == UsniAdaptor::t('order', 'Expired'))
        {
            $labelWidget = UiLabel::widget(['content' => $value, 'modifier' => UiHtml::COLOR_DEFAULT, 'id' => $id]);
        }
        elseif ($value == UsniAdaptor::t('order', 'Failed'))
        {
            $labelWidget = UiLabel::widget(['content' => $value, 'modifier' => UiHtml::COLOR_DEFAULT, 'id' => $id]);
        }
        elseif ($value == UsniAdaptor::t('order', 'Processed'))
        {
            $labelWidget = UiLabel::widget(['content' => $value, 'modifier' => UiHtml::COLOR_DEFAULT, 'id' => $id]);
        }
        elseif ($value == UsniAdaptor::t('order', 'Processing'))
        {
            $labelWidget = UiLabel::widget(['content' => $value, 'modifier' => UiHtml::COLOR_DEFAULT, 'id' => $id]);
        }
        elseif ($value == UsniAdaptor::t('order', 'Refunded'))
        {
            $labelWidget = UiLabel::widget(['content' => $value, 'modifier' => UiHtml::COLOR_INFO, 'id' => $id]);
        }
        elseif ($value == UsniAdaptor::t('order', 'Reversed'))
        {
            $labelWidget = UiLabel::widget(['content' => $value, 'modifier' => UiHtml::COLOR_WARNING, 'id' => $id]);
        }
        elseif ($value == UsniAdaptor::t('order', 'Shipped'))
        {
            $labelWidget = UiLabel::widget(['content' => $value, 'modifier' => UiHtml::COLOR_DEFAULT, 'id' => $id]);
        }
        elseif ($value == UsniAdaptor::t('order', 'Voided'))
        {
            $labelWidget = UiLabel::widget(['content' => $value, 'modifier' => UiHtml::COLOR_DANGER, 'id' => $id]);
        }
        return $labelWidget;
    }

    /**
     * Gets label for the status.
     * @param integer $status.
     * @return string
     */
    public static function getLabel($status, $language = null)
    {
        if($language == null)
        {
            $language   = UsniAdaptor::app()->language;
        }
        $record     = OrderStatusTranslated::find()->where('owner_id = :oid AND language = :language', 
                                                                         [':oid' => $status, ':language' => $language])->asArray()->one();
        return $record['name'];
    }
    
    /**
     * Get status id
     * @param string $statusLabel
     * @return int
     */
    public static function getStatusId($statusLabel)
    {
        $language   = UsniAdaptor::app()->language;
        $record     = OrderStatusTranslated::find()->where('name = :name AND language = :language', 
                                                                         [':name' => $statusLabel, ':language' => $language])->asArray()->one();
        return $record['owner_id'];
    }
    
    /**
     * Get all order status.
     * @return array
     */
    public static function getAllOrderStatus()
    {
        $language       = UsniAdaptor::app()->language;
        $orderStatus    = OrderStatusTranslated::find()->where('language = :lang', [':lang' => $language])->asArray()->all();
        $data           = ArrayUtil::map($orderStatus, 'name', 'owner_id');
        return $data;
    }
    
    /**
     * Check if allowed to delete
     * @param OrderStatus $model
     * @return boolean
     */
    public static function checkIfAllowedToDelete($model)
    {
        //Check the orders associated
        $orders = OrderUtil::getOrdersByAttribute('status', $model['id']);
        if(empty($orders))
        {
            return true;
        }
        return false;
    }
}