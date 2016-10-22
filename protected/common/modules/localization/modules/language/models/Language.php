<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\localization\modules\language\models;

use usni\library\components\UiSecuredActiveRecord;
use usni\UsniAdaptor;
use common\modules\localization\modules\language\utils\LanguageUtil;
/**
 * Language active record.
 * 
 * @package common\modules\localization\modules\language\models
 */
class Language extends UiSecuredActiveRecord
{
    /**
     * Upload File Instance.
     * @var string
     */
    public $uploadInstance;
    /**
     * Upload File Instance.
     * @var string
     */
    public $savedImage;
	/**
     * @inheritdoc
     */
	public function rules()
	{
		return [
                    [['name', 'code', 'locale'],                'required'],
                    [['uploadInstance'], 'image', 'skipOnEmpty' => true, 'extensions' => 'jpg, png, gif'],
                    [['name', 'code'],                          'unique', 'on' => 'create'],
                    [['name', 'code'],                          'unique', 'filter' => ['!=', 'id', $this->id], 'on' => 'update'],
                    [['sort_order', 'status'],                  'integer'],
                    ['name',                                    'string'],
                    ['code',                                    'string'],
                    ['locale',                                  'string'],
                    ['image',                                   'string', 'max'=>255],
                    [['id', 'name', 'code', 'locale', 'image', 'sort_order', 'status'], 'safe'],
               ];
	}

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        $scenarios                = parent::scenarios();
        $scenarios['create']      = $scenarios['update'] = ['name', 'code', 'locale', 'sort_order', 'status', 'image'];
        $scenarios['bulkedit']    = ['status'];
        $scenarios['deleteimage'] = ['image'];
        return $scenarios;
    }

	/**
     * @inheritdoc
     */
	public function attributeLabels()
	{
		$labels = [
                        'name'					 => UsniAdaptor::t('application',  'Name'),
                        'code'					 => UsniAdaptor::t('localization', 'Code'),
                        'locale'				 => UsniAdaptor::t('localization', 'Locale'),
                        'image'					 => UsniAdaptor::t('application',  'Image'),
                        'sort_order'			 => UsniAdaptor::t('application',  'Sort Order'),
                        'status'				 => UsniAdaptor::t('application',  'Status'),
                  ];
        return parent::getTranslatedAttributeLabels($labels);
	}

    /**
     * @inheritdoc
     */
    public static function getLabel($n = 1)
    {
        return ($n == 1) ? UsniAdaptor::t('language', 'Language') : UsniAdaptor::t('language', 'Languages');
    }
    
    /**
     * @inheritdoc
     */
    public function beforeDelete()
    {
        if(parent::beforeDelete())
        {
            return LanguageUtil::checkIfAllowedToDelete($this);
        }
        return false;
    }
}