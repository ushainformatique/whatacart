<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace customer\models;

use customer\models\Customer;
use usni\library\modules\users\models\Person;
use usni\library\modules\users\models\Address;
use customer\notifications\NewCustomerEmailNotification;
/**
 * CustomerEditForm class file
 *
 * @package customer\models
 */
class CustomerEditForm extends \usni\library\modules\users\models\UserEditForm
{
    /**
     * Customer model
     * @var Customer 
     */
    public $customer;
    
    /**
     * @inheritdoc
     */
    public function __construct($config = array())
    {
        if (!empty($config)) 
        {
            \Yii::configure($this, $config);
        }
        if($this->customer == null)
        {
            $this->customer = new Customer(['scenario' => $this->scenario]);
        }
        if($this->person == null)
        {
            $this->person = new Person(['scenario' => $this->scenario]);
        }
        if($this->address == null)
        {
            $this->address = new Address(['scenario' => $this->scenario]);
        }
    }
    
    /**
     * @inheritdoc
     */
    public static function getLabel($n = 1)
    {
        return Customer::getLabel($n);
    }
    
    /**
     * @inheritdoc
     */
    protected function getEmailNotification()
    {
        return new NewCustomerEmailNotification(['user' => $this->customer, 'person' => $this->person]);
    }
}
