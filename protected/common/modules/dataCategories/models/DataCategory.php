<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace common\modules\dataCategories\models;

use usni\UsniAdaptor;
use usni\library\components\TranslatableActiveRecord;
use usni\library\components\UiBaseActiveRecord;
use common\modules\dataCategories\utils\DataCategoryUtil;

/**
 * DataCategory class file.
 * 
 * @package common\modules\dataCategories\models
 */
class DataCategory extends TranslatableActiveRecord
{
    const ROOT_CATEGORY_ID = 1;
    
	/**
     * @inheritdoc
     */
	public function rules()
	{
		return [
                    [['name', 'status'], 'required'],
                    ['name',             'unique', 'targetClass' => DataCategoryTranslated::className(), 'targetAttribute' => ['name', 'language'], 'on' => 'create'],
                    ['name', 'unique', 'targetClass' => DataCategoryTranslated::className(), 'targetAttribute' => ['name', 'language'], 'filter' => ['!=', 'owner_id', $this->id], 'on' => 'update'],
                    ['name',             'string', 'max' => 128],
                    ['status',           'default', 'value' => UiBaseActiveRecord::STATUS_ACTIVE],
                    ['status',         'number'],
                    [['name', 'description', 'status'], 'safe'],
                ];
	}

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        $commonAttributes       = ['name', 'description', 'status'];
        $scenarios['create']    = $commonAttributes;
        $scenarios['update']    = $commonAttributes;
        $scenarios['bulkedit']  = ['status'];
        return $scenarios;
    }

	/**
     * @inheritdoc
     */
	public function attributeLabels()
	{
		$labels = [
                        'name'            => UsniAdaptor::t('application', 'Name'),
                        'description'     => UsniAdaptor::t('application', 'Description'),
                        'status'          => UsniAdaptor::t('application', 'Status'),
                  ];
        return parent::getTranslatedAttributeLabels($labels);
	}

	/**
     * @inheritdoc
     */
    public static function getLabel($n = 1)
    {
        return ($n == 1) ? UsniAdaptor::t('dataCategories', 'Data Category') : UsniAdaptor::t('dataCategories', 'Data Categories');
    }
    
    /**
     * @inheritdoc
     */
    public static function getTranslatableAttributes()
    {
        return ['name', 'description'];
    }
    
    /**
     * @inheritdoc
     */
    public function attributeHints()
    {
        return array(
            'name'          => UsniAdaptor::t('applicationhint', 'Minimum 3 characters'),
            'description'   => UsniAdaptor::t('applicationhint', 'Description for the site'),
            'status'        => UsniAdaptor::t('datacategoryhint', 'Status for datacategory')
        );
    }
    
    /**
     * @inheritdoc
     */
    public function beforeDelete()
    {
        if(parent::beforeDelete())
        {
            return DataCategoryUtil::checkIfAllowedToDelete($this);
        }
        return false;
    }
}