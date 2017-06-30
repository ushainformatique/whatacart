<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\stores\models;

use usni\UsniAdaptor;
use usni\library\db\ActiveRecord;
/**
 * StoreConfiguration active record.
 *
 * @package common\modules\stores\models
 */
class StoreConfiguration extends ActiveRecord
{   
    /**
     * @inheritdoc
     */
	public function rules()
	{
		return [
                    [
                        [['store_id', 'code', 'key', 'value', 'category'],  'required'],
                        [['store_id', 'code', 'key', 'value', 'category'],  'safe'],
                    ]
               ];
	}

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        $scenario = parent::scenarios();
        $scenario['create'] = $scenario['update'] = ['store_id', 'code', 'key', 'value', 'category'];
        return $scenario;
    }
    
    /**
     * @inheritdoc
     */
	public function attributeLabels()
	{
		return [
                        'id'        => UsniAdaptor::t('application','Id'),
                        'store_id'  => UsniAdaptor::t('stores', 'Store'),
                        'code'      => UsniAdaptor::t('application', 'Code'),
                        'key'       => UsniAdaptor::t('application', 'Key'),
                        'value'     => UsniAdaptor::t('application', 'Value'),
                        'category'  => UsniAdaptor::t('stores', 'Category'),
                  ];
	}
    
    /**
     * @inheritdoc
     */
    public static function getLabel($n = 1)
    {
        return UsniAdaptor::t('settings', 'Settings');
    }
    
    /**
     * @inheritdoc
     */
	public function attributeHints()
	{
		return [];
	}
}