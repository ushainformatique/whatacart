<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace common\modules\payment\models\paypal_standard;

use usni\UsniAdaptor;
/**
 * PaypalOrderStatus class file
 *
 * @package common\modules\payment\models\paypal_standard
 */
class PaypalOrderStatus extends \yii\base\Model
{
    /**
     * @var string 
     */
    public $canceled_reversal_status;
    /**
     * @var string 
     */
    public $completed_status;
    /**
     * @var string 
     */
    public $denied_status;
    /**
     * @var string 
     */
    public $expired_status;
    /**
     * @var string 
     */
    public $failed_status;
    /**
     * @var string 
     */
    public $pending_status;
    /**
     * @var string 
     */
    public $processed_status;
    /**
     * @var string 
     */
    public $refunded_status;
    /**
     * @var string 
     */
    public $reversed_status;
    /**
     * @var string 
     */
    public $voided_status;
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
                    [['canceled_reversal_status', 'completed_status', 'denied_status', 'expired_status', 'failed_status', 'pending_status', 
                      'processed_status', 'refunded_status', 'reversed_status', 'voided_status'], 'safe'],
               ];
    }
    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
                    'canceled_reversal_status'  => UsniAdaptor::t('orderstatus', 'Canceled Reversal Status'),
                    'completed_status'          => UsniAdaptor::t('orderstatus', 'Completed Status'),
                    'denied_status'             => UsniAdaptor::t('orderstatus', 'Denied Status'),
                    'expired_status'            => UsniAdaptor::t('orderstatus', 'Expired Status'),
                    'failed_status'             => UsniAdaptor::t('orderstatus', 'Failed Status'),
                    'pending_status'            => UsniAdaptor::t('orderstatus', 'Pending Status'),
                    'processed_status'          => UsniAdaptor::t('orderstatus', 'Processed Status'),
                    'refunded_status'           => UsniAdaptor::t('orderstatus', 'Refunded Status'),
                    'reversed_status'           => UsniAdaptor::t('orderstatus', 'Reversed Status'),
                    'voided_status'             => UsniAdaptor::t('orderstatus', 'Voided Status'),
               ];
    }
}
