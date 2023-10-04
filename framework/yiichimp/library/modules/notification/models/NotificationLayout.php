<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\modules\notification\models;

use usni\library\db\TranslatableActiveRecord;
use usni\UsniAdaptor;
/**
 * NotificationLayout active record.
 * 
 * @package usni\library\modules\notification\models
 */
class NotificationLayout extends TranslatableActiveRecord
{
	/**
     * @inheritdoc
     */
	public function rules()
	{
		return [
                    [['name', 'content'],       'required'],
                    ['name',  'unique', 'targetClass' => NotificationLayoutTranslated::className(), 'targetAttribute' => ['name', 'language'], 'on' => 'create'],
                    ['name', 'unique', 'targetClass' => NotificationLayoutTranslated::className(), 'targetAttribute' => ['name', 'language'], 'filter' => ['!=', 'owner_id', $this->id], 'on' => 'update'],
                    ['name',                    'string', 'max'=>64],
                    [['id', 'name', 'content'], 'safe'],
               ];
	}

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        $scenario           = parent::scenarios();
        $scenario['create'] = $scenario['update'] = ['name', 'content'];
        return $scenario;
    }
    
    /**
     * @inheritdoc
     */
	public function attributeLabels()
	{
        $labels =   [
                        'id'      => UsniAdaptor::t('application', 'Id'),
                        'name'    => UsniAdaptor::t('application', 'Name'),
                        'content' => UsniAdaptor::t('cms', 'Content'),
                    ];
        return parent::getTranslatedAttributeLabels($labels);
	}

	/**
     * @inheritdoc
     */
    public static function getLabel($n=1)
    {
        return ($n == 1) ? UsniAdaptor::t('notification', 'Layout') : UsniAdaptor::t('notification', 'Layouts');
    }

    /**
     * @inheritdoc
     */
    public function attributeHints()
    {
        return [
                 'name' => UsniAdaptor::t('applicationhint', 'Minimum 3 characters'),
               ];
    }

    /**
     * @inheritdoc
     */
    public function beforeDelete()
    {
        if(parent::beforeDelete())
        {
            $tableName = NotificationTemplate::tableName();
            UsniAdaptor::db()->createCommand()->update($tableName,
                                                    array('layout_id' => null),
                                                    'layout_id = :layoutid',
                                                    array(':layoutid' => $this->id))->execute();
            return true;
        }
        return false;
    }
    
    /**
     * @inheritdoc
     */
    public static function getTranslatableAttributes()
    {
        return ['name', 'content'];
    }
}