<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace customer\models;

use usni\UsniAdaptor;
use usni\library\db\ActiveRecord;
/**
 * CustomerActivity class file
 *
 * @package customer\models
 */
class CustomerActivity extends ActiveRecord
{   
    /**
     * @inheritdoc
     */
    public static function getLabel($n = 1)
    {
        return UsniAdaptor::t('customer', 'Customer Activity');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
       
        $rules = [
                    [['customer_id',  'key', 'data', 'ip'], 'required'],
                 ];
        return $rules;
    }
    
    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        
        $scenarios                  = parent::scenarios();
        $commonAttributes           = ['customer_id',  'key', 'data', 'ip'];
        $scenarios['create']        = $scenarios['update'] = $commonAttributes;
        return $scenarios;
    }
}