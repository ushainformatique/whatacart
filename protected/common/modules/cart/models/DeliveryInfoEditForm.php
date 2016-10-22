<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace cart\models;

/**
 * DeliveryInfoEditForm class file
 * @package cart\models
 */
class DeliveryInfoEditForm extends BillingInfoEditForm
{
    /**
     * Same as billing address
     * @var boolean 
     */
    public $sameAsBillingAddress;
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        $rules      = parent::rules();
        $rules[]    = ['sameAsBillingAddress', 'boolean'];
        return $rules;
    }
}
