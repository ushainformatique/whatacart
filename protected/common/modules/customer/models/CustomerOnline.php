<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace customer\models;

use usni\UsniAdaptor;
use usni\library\db\ActiveRecord;
/**
 * CustomerOnline class file.
 *
 * @package customer\models
 */
class CustomerOnline extends ActiveRecord
{   
    /**
     * @inheritdoc
     */
    public static function getLabel($n = 1)
    {
        return UsniAdaptor::t('customer', 'Customer Online');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $rules = [
                    ['url', 'url'],
                    ['ip',  'unique'],
                    [['ip', 'customer_id', 'url', 'referer'], 'safe'],
                 ];
        return $rules;
    }
    
    /**
     * @inheritdoc
     */
    public function scenarios()
    {   
        $scenarios              = parent::scenarios();
        $scenarios['create']    = $scenarios['update'] = ['ip', 'customer_id', 'url', 'referer'];
        return $scenarios;
    }
}