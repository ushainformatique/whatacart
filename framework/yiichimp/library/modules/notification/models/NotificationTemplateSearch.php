<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\modules\notification\models;


use yii\base\Model;
use usni\library\dataproviders\ArrayRecordDataProvider;
use usni\UsniAdaptor;
/**
 * NotificationTemplateSearch class file.
 * This is the search class for model NotificationTemplate.
 * 
 * @package usni\library\modules\notification\models
 */
class NotificationTemplateSearch extends NotificationTemplate
{
    use \usni\library\traits\SearchTrait;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return NotificationTemplate::tableName();
    }

	/**
     * @inheritdoc
     */
	public function rules()
	{
		return [
                    [['type', 'notifykey', 'subject', 'content', 'layout_id', 'layout'], 'safe']
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
        $tableName      = UsniAdaptor::tablePrefix() . 'notification_template';
        $trTableName    = UsniAdaptor::tablePrefix() . 'notification_template_translated';
        $layoutTableName = UsniAdaptor::tablePrefix() . 'notification_layout_translated';
        $query          = new \yii\db\Query();
        $query->select('nt.*, ntt.subject, ntt.content, ltt.name AS layout')
              ->from([$tableName . ' nt'])
              ->innerJoin($trTableName . ' ntt', 'nt.id = ntt.owner_id AND ntt.language = :language', [':language' => $this->language])
              ->leftJoin($layoutTableName  . ' ltt', 'nt.layout_id = ltt.owner_id AND ltt.language = :language1', [':language1' => $this->language]);
        $dataProvider   = new ArrayRecordDataProvider([
            'query' => $query,
            'key'   => 'id',
            'sort'  => ['attributes' => ['type', 'notifykey', 'subject', 'content', 'layout_id' => [
                                                                                                        'asc' => ['layout' => SORT_ASC],
                                                                                                        'desc' => ['layout' => SORT_DESC]
                                                                                                    ]
                                        ]
                        ]
        ]);


        // Validate data
        if (!$this->validate())
        {
            return $dataProvider;
        }
        $query->andFilterWhere(['like', 'type',         $this->type]);
        $query->andFilterWhere(['like', 'notifykey',    $this->notifykey]);
        $query->andFilterWhere(['like', 'subject',      $this->subject]);
        $query->andFilterWhere(['like', 'content',      $this->content]);
        $query->andFilterWhere(['like', 'layout_id',    $this->layout_id]);
        if($this->canAccessOwnedRecordsOnly('notificationtemplate'))
        {
            $query->andFilterWhere(['nt.created_by' => $this->getUserId()]);
        }
        return $dataProvider;
    }
}