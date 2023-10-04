<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\modules\users\models;

use usni\UsniAdaptor;
/**
 * SettingsForm class file.
 * 
 * @package usni\library\modules\users\models
 */
class SettingsForm extends \yii\base\Model
{
    /**
     * Duration for password token expiry.
     * @var int
     */
    public $passwordTokenExpiry;
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
                    [['passwordTokenExpiry'],   'number', 'integerOnly' => true],
                    [['passwordTokenExpiry'],   'required'],
               ];
    }
    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
                    'passwordTokenExpiry' => UsniAdaptor::t('users', 'Password token expiry'),
               ];
    }

    /**
     * @inheritdoc
     */
    public function attributeHints()
    {
        return [
                    'passwordTokenExpiry' => UsniAdaptor::t('userhint', 'Duration after which password token expire in seconds'),
               ];
    }
}