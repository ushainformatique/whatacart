<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace cart\models;

use yii\base\Model;
use usni\UsniAdaptor;
/**
 * DeliveryOptionsEditForm class file
 * 
 * @package cart\models
 */
class DeliveryOptionsEditForm extends Model
{
    /**
     * Shipping type
     * @var int 
     */
    public $shipping;
    
    /**
     * Comments related to delivery options.
     * @var string 
     */
    public $comments;
    
    /**
     * Calculate price for shipping.
     * @var string 
     */
    public $shipping_fee;
    
    /**
     * Validation rules for the model.
     * @return array Validation rules for model attributes.
     */
    public function rules()
    {
        return array(
            [['shipping', 'comments', 'shipping_fee'],  'safe'],
        );
    }

    /**
     * @inheritdoc
     */
    public static function getLabel($n = 1)
    {
        return UsniAdaptor::t('cart', 'Delivery Options');
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
                'shipping'    => UsniAdaptor::t('shipping', 'Shipping'),
                'comments'    => UsniAdaptor::t('application', 'Comments'),
                'shipping_fee'    => UsniAdaptor::t('shipping', 'Shipping Fee'),
               ];
    }
    
    /**
     * @inheritdoc
     */
    public function attributeHints()
    {
        return [
                'shipping'    => UsniAdaptor::t('shippinghint', 'Shipping Method'),
                'comments'    => UsniAdaptor::t('shippinghint', 'Comments associated with the shipping'),
                'shipping_fee'    => UsniAdaptor::t('shippinghint', 'Shipping fee'),
               ];
    }
}
