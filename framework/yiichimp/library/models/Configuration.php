<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\models;

use usni\library\db\ActiveRecord;
use usni\UsniAdaptor;
/**
 * Configuration class file.
 * 
 * @package usni\library\models
 */
class Configuration extends ActiveRecord
{
	/**
     * @inheritdoc
     */
	public function rules()
	{
		return [
                    [['module', 'key'],                 'required'],
                    [['module', 'key'],                 'string', 'max'=>32],
                    [['id', 'module', 'key', 'value'],  'safe'],
               ];
	}
    
    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        $scenario           = parent::scenarios();
        $scenario['create'] = ['module', 'key', 'value'];
        $scenario['update'] = ['module', 'key', 'value'];
        return $scenario;
    }
    
    /**
     * @inheritdoc
     */
	public function attributeLabels()
	{
		return [
                    'id'        => UsniAdaptor::t('application', 'Id'),
                    'module'    => UsniAdaptor::t('application', 'Module'),
                    'key'       => UsniAdaptor::t('application', 'Key'),
                    'value'     => UsniAdaptor::t('application', 'Value'),
               ];
	}
    
    /**
     * @inheritdoc
     */
    public function getModelConfig()
    {
        return [];
    }
}