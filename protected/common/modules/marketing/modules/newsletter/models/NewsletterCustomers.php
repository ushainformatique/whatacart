<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace newsletter\models;

use usni\library\db\ActiveRecord;
use usni\UsniAdaptor;
/**
 * Newsletter active record.
 * 
 * @package newsletter\models
 */
class NewsletterCustomers extends ActiveRecord
{
    /**
     * Check newsletter is subscribe or not.
     * @var boolean
     */
    public $is_subscribe;
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
                    [['customer_id', 'email'],                          'required'],
                    ['email',                                           'email'],
                    ['email',                                           'unique'],
                    [['id', 'customer_id', 'email', 'is_subscribe'],    'safe'],
               ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        $scenarios          = parent::scenarios();
        $scenarios['send']  = ['customer_id', 'email'];
        return $scenarios;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        $labels =   [
                        'customer_id'   => UsniAdaptor::t('customer', 'Customer'),
                        'email'         => UsniAdaptor::t('users', 'Email')
                    ];
        return parent::getTranslatedAttributeLabels($labels);
    }

    /**
     * @inheritdoc
     */
    public static function getLabel($n = 1)
    {
        return ($n == 1) ? UsniAdaptor::t('newsletter', 'Newsletter Customer') : UsniAdaptor::t('newsletter', 'Newsletter Customers');
    }
}
