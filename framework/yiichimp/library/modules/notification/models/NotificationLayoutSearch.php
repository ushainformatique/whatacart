<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\modules\notification\models;

use usni\library\dataproviders\ArrayRecordDataProvider;
use yii\base\Model;
use usni\UsniAdaptor;
/**
 * NotificationLayoutSearch class file
 * 
 * This is the search class for model NotificationLayout.
 * @package usni\library\modules\notification\models
 */
class NotificationLayoutSearch extends NotificationLayout
{
    use \usni\library\traits\SearchTrait;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return NotificationLayout::tableName();
    }

	/**
     * @inheritdoc
     */
	public function rules()
	{
		return [
                    [['name'], 'safe']
               ];
	}

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return Model::scenarios();
    }

    /**
     * Search based on get params.
     *
     * @return ArrayRecordDataProvider
     */
    public function search()
    {
        $tableName      = UsniAdaptor::tablePrefix() . 'notification_layout';
        $trTableName    = UsniAdaptor::tablePrefix() . 'notification_layout_translated';
        $query          = new \yii\db\Query();
        $query->select('nl.*, nlt.name')
              ->from([$tableName . ' nl', $trTableName . ' nlt'])
              ->where('nl.id = nlt.owner_id AND nlt.language = :language', [':language' => $this->language]);
        $dataProvider   = new ArrayRecordDataProvider([
            'query' => $query,
            'key'   => 'id',
            'sort'  => ['attributes' => ['name']]
        ]);

        // Validate data
        if (!$this->validate())
        {
            return $dataProvider;
        }
        $query->andFilterWhere(['like', 'name',   $this->name]);
        if($this->canAccessOwnedRecordsOnly('notificationlayout'))
        {
            $query->andFilterWhere(['nl.created_by' => $this->getUserId()]);
        }
        return $dataProvider;
    }
}