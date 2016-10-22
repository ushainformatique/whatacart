<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace customer\models;

use customer\models\Customer;
/**
 * CustomerBulkEditForm class file
 * @package customer\models
 */
class CustomerBulkEditForm extends \usni\library\modules\users\models\UserBulkEditForm
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
        parent::__construct($config);
        if($this->customer == null)
        {
            $this->customer = new Customer(['scenario' => $this->scenario]);
        }
    }
}
