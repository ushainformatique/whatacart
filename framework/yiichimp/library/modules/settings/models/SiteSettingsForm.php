<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\modules\settings\models;

use usni\UsniAdaptor;
/**
 * SiteSettingsForm class file.
 * 
 * @package usni\library\modules\settings\models
 */
class SiteSettingsForm extends \yii\base\Model
{
    /**
     * Meta keywords for the site.
     * @var string
     */
    public $metaKeywords;
    /**
     * Meta description for the site.
     * @var string
     */
    public $metaDescription;
    /**
     * Store sitename.
     * @var string
     */
    public $siteName;

    /**
     * Store description.
     * @var string
     */
    public $siteDescription;

    /**
     * Site maintenance mode.
     * @var string
     */
    public $siteMaintenance;
    
    /**
     * Site logo.
     * @var string
     */
    public $logo;
    /**
     * Site tag line.
     * @var string
     */
    public $tagline;
    /**
     * Sitemaintenence mode custom message
     * $var string
     */
    public $customMaintenanceModeMessage;
    /**
     * Sitemaintenence mode custom message
     * $var string
     */
    public $logoAltText;
    
    /**
     * Upload File Instance.
     * @var string
     */
    public $uploadInstance;
    
    /**
     * Upload File Instance.
     * @var string
     */
    public $savedLogo;
    
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->savedLogo  = UsniAdaptor::app()->configManager->getValue('application', 'logo');
    }
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
                    [['siteName', 'siteDescription', 'metaKeywords', 'metaDescription'],       'required'],
                    [['siteName', 'siteDescription', 'metaKeywords', 'metaDescription'],       'string'],
                    ['siteMaintenance',                                                        'default', 'value' => '0'],
                    ['tagline',                                                                'string'],
                    [['uploadInstance', 'logo'], 'image', 'skipOnEmpty' => true, 'extensions' => 'jpg, png, gif, jpeg'],
                    [['tagline', 'customMaintenanceModeMessage', 'logoAltText', 'logo'],        'safe']
               ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
                    'siteName'              => UsniAdaptor::t('application', 'Site Name'),
                    'siteDescription'       => UsniAdaptor::t('application', 'Site Description'),
                    'metaKeywords'          => UsniAdaptor::t('application', 'Meta Keywords'),
                    'metaDescription'       => UsniAdaptor::t('application', 'Meta Description'),
                    'superUsername'         => UsniAdaptor::t('users', 'Super Username'),
                    'siteMaintenance'       => UsniAdaptor::t('settings', 'Maintenance mode'),
                    'logo'                  => UsniAdaptor::t('application', 'Logo'),
                    'tagline'               => UsniAdaptor::t('settings', 'Tagline'),
                    'customMaintenanceModeMessage'  => UsniAdaptor::t('settings', 'Custom Maintenance Mode Message'),
                    'logoAltText'           => UsniAdaptor::t('application', 'Logo AltText')
               ];
    }

    /**
     * @inheritdoc
     */
    public function attributeHints()
    {
        return [
                    'siteName'        => UsniAdaptor::t('applicationhint', 'Name of the site'),
                    'siteDescription' => UsniAdaptor::t('applicationhint', 'Description for the site'),
                    'metaKeywords'    => UsniAdaptor::t('applicationhint', 'Meta keywords for the site'),
                    'metaDescription' => UsniAdaptor::t('applicationhint', 'Meta description for the site'),
                    'siteMaintenance' => UsniAdaptor::t('settingshint', 'Site is in maintenance mode'),
                    'logo'            => UsniAdaptor::t('settingshint', 'Logo for the site'),
                    'tagline'         => UsniAdaptor::t('settingshint', 'Tagline for the site'),
                    'customMaintenanceModeMessage'  => UsniAdaptor::t('settingshint', 'Custom maintenance message'),
                    'logoAltText'     => UsniAdaptor::t('applicationhint', 'Alt Text')
               ];
    }
    
    /**
     * @inheritdoc
     */
    public static function getLabel($n = 1)
    {
        return UsniAdaptor::t('settings', 'Site Settings');
    }
}