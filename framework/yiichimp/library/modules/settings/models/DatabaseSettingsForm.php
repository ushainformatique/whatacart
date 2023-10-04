<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\modules\settings\models;

use usni\UsniAdaptor;
/**
 * DatabaseSettingsForm class file.
 * 
 * @package usni\library\modules\settings\models
 */
class DatabaseSettingsForm extends \yii\base\Model
{
    /**
     * Is schema caching enabled.
     * @var bool
     */
    public $enableSchemaCache;
    /**
     * Schema caching duration
     * @var string
     */
    public $schemaCachingDuration;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
                    [['schemaCachingDuration'],   'number', 'integerOnly' => true],
                    ['enableSchemaCache',         'default', 'value' => 1],
                    ['schemaCachingDuration',     'default', 'value' => 3600],
               ];
    }
    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
                    'enableSchemaCache'      => UsniAdaptor::t('settings', 'Enable schema cache'),
                    'schemaCachingDuration'  => UsniAdaptor::t('settings', 'Schema caching duration'),
               ];
    }

    /**
     * @inheritdoc
     */
    public function attributeHints()
    {
        return [
                    'enableSchemaCache'       => UsniAdaptor::t('settingshint', 'Enable database schema caching'),
                    'schemaCachingDuration'   => UsniAdaptor::t('settingshint', 'Number of seconds that table metadata can remain valid in cache'),
               ];
    }
}