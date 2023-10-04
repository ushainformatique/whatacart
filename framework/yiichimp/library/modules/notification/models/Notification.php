<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */

namespace usni\library\modules\notification\models;

use usni\library\db\ActiveRecord;
use usni\UsniAdaptor;
/**
 * Notification active record.
 *
 * @package usni\library\modules\notification\models
 */
class Notification extends ActiveRecord
{
    /**
     * Constant for Notification mail type.
     */
    const TYPE_EMAIL       = 'email';

    /**
     * Constant for Notification normal priority.
     * @see class.phpmailer.com $Priority
     */
    const PRIORITY_NORMAL  = 3;

    /**
     * Constant for Notification low priority.
     */
    const PRIORITY_LOW     = 5;

    /**
     * Constant for Notification high priority.
     */
    const PRIORITY_HIGH    = 1;

    /**
     * Constant for Notification pending status.
     */
    const STATUS_PENDING   = 0;

    /**
     * Constant for Notification sent status.
     */
    const STATUS_SENT      = 1;

    /**
     * @inheritdoc
     */
	public function rules()
	{
		return [
                    [['modulename', 'type', 'data'],        'required'],
                    [['priority', 'type'],                  'integer'],
                    ['status',                              'default', 'value' => Notification::STATUS_PENDING],
                    [['modulename'],                        'string', 'max'=>16],
                    ['startDate',                           'string'],
                    ['endDate',                             'string'],
                    [['modulename', 'type', 'data', 'status', 'priority', 'senddatetime'], 'safe'],
               ];
	}

	/**
     * @inheritdoc
     */
	public function attributeLabels()
	{
        $labels = [
                        'id'            => UsniAdaptor::t('application', 'Id'),
                        'modulename'    => UsniAdaptor::t('notification','Module Name'),
                        'type'          => UsniAdaptor::t('notification','Type'),
                        'data'          => UsniAdaptor::t('notification','Data'),
                        'status'        => UsniAdaptor::t('notification','Status'),
                        'priority'      => UsniAdaptor::t('notification','Priority'),
                        'senddatetime'  => UsniAdaptor::t('notification','Send Date Time')
                  ];
        return parent::getTranslatedAttributeLabels($labels);
	}

    /**
     * @inheritdoc
     */
    public static function getLabel($n = 1)
    {
        return ($n == 1) ? UsniAdaptor::t('notification', 'Notification') : UsniAdaptor::t('users', 'Notifications');
    }

   /**
     * @inheritdoc
     */
    public function attributeHints()
    {
        return [];
    }
}