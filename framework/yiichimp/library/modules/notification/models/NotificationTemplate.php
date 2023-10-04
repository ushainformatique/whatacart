<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\modules\notification\models;

use usni\library\db\TranslatableActiveRecord;
use usni\UsniAdaptor;
use usni\library\modules\notification\models\NotificationLayout;
/**
 * NotificationTemplate active record.
 *
 * @package usni\library\modules\notification\models
 */
class NotificationTemplate extends TranslatableActiveRecord
{
	/**
     * @inheritdoc
     */
	public function rules()
	{
		return [
                    [['type', 'notifykey', 'subject', 'content'],                   'required', 'except' => 'bulkedit'],
                    [['notifykey'],  'unique', 'targetAttribute' => ['notifykey', 'type'], 'on' => 'create'],
                    ['notifykey',    'unique', 'targetAttribute' => ['notifykey', 'type'], 'filter' => ['!=', 'id', $this->id], 'on' => 'update'],
                    [['subject', 'content', 'type', 'notifykey', 'layout_id'],      'safe'],
               ];
	}
    
    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        $scenario               = parent::scenarios();
        $scenario['create']     = ['type', 'notifykey', 'subject', 'content', 'layout_id'];
        $scenario['update']     = ['type', 'notifykey', 'subject', 'content', 'layout_id'];
        $scenario['bulkedit']   = ['type'];
        return $scenario;
    }
    
     /**
     * Get Notification Layout for the Template.
     * @return \NotificationLayout
     */
    public function getLayout()
    {
        return $this->hasOne(NotificationLayout::className(), ['id' => 'layout_id']);
    }
    
    /**
     * @inheritdoc
     */
	public function attributeLabels()
	{
		$labels = [
                                'id'          => UsniAdaptor::t('application',  'Id'),
                                'notifykey'   => UsniAdaptor::t('notification', 'Notify Key'),
                                'type'        => UsniAdaptor::t('notification', 'Type'),
                                'subject'     => UsniAdaptor::t('application', 'Subject'),
                                'content'     => UsniAdaptor::t('notification', 'Content'),
                                'layout_id'   => UsniAdaptor::t('notification', 'Notification Layout')
                          ];
        return parent::getTranslatedAttributeLabels($labels);
	}

    /**
     * @inheritdoc
     */
    public static function getLabel($n=1)
    {
        return ($n == 1) ? UsniAdaptor::t('notification', 'Template') : UsniAdaptor::t('notification', 'Templates');
    }

    /**
     * @inheritdoc
     */
    public function attributeHints()
    {
        return [
                    'subject'   => UsniAdaptor::t('notificationhint', 'Subject for the email'),
                    'notifykey' => UsniAdaptor::t('notificationhint', 'Notification Key'),
                    'type'      => UsniAdaptor::t('notificationhint', 'Type of notification'),
               ];
    }
    
    /**
     * @inheritdoc
     */
    public static function getTranslatableAttributes()
    {
        return ['subject', 'content'];
    }
}