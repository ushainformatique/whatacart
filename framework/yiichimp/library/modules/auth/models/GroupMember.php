<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\modules\auth\models;

use usni\UsniAdaptor;
use usni\library\db\ActiveRecord;
/**
 * This is the model class for table "tbl_group_members".
 * 
 * @package usni\library\modules\auth\models
 */
class GroupMember extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        $commonAttributes = ['group_id', 'member_id', 'member_type'];
        $scenarios['create'] = $scenarios['update'] = $commonAttributes;
        return $scenarios;
    }
    
	/**
     * @inheritdoc
     */
	public function rules()
	{
		return [
			[['group_id', 'member_id', 'member_type'], 'required'],
			[['group_id', 'member_id'], 'number', 'integerOnly'=>true],
			[['group_id', 'member_id', 'member_type'], 'safe'],
		];
	}

	/**
     * Get group for the member.
     * @return ActiveQuery
     */
	public function getGroup()
	{
		return $this->hasOne(Group::className(), ['id' => 'group_id']);
	}

	/**
     * @inheritdoc
     */
	public function attributeLabels()
	{
		$labels = [
                    'group_id'    => Group::getLabel(1),
                    'member_id'   => UsniAdaptor::t('auth', 'Member'),
                    'member_type' => UsniAdaptor::t('auth', 'Member Type'),
                  ];
        return parent::getTranslatedAttributeLabels($labels);
	}
}