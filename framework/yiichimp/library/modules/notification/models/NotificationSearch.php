<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\modules\notification\models;

use yii\base\Model;
use usni\library\modules\notification\models\Notification;
use usni\library\dataproviders\ArrayRecordDataProvider;
use usni\UsniAdaptor;
/**
 * NotificationSearch class file
 * This is the search class for model Notification.
 * 
 * @package usni\library\modules\notification\models
 */
class NotificationSearch extends Notification
{
    use \usni\library\traits\SearchTrait;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return Notification::tableName();
    }

	/**
     * @inheritdoc
     */
	public function rules()
	{
		return [
                    [['modulename', 'type', 'data', 'status', 'priority', 'senddatetime'], 'safe'],
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
     * @return yii\data\ActiveDataProvider
     */
    public function search()
    {
        $query          = new \yii\db\Query();
        $table          = UsniAdaptor::tablePrefix() . 'notification';
        $query->select('*')
              ->from($table);
        $dataProvider   = new ArrayRecordDataProvider([
            'query' => $query,
            'key'   => 'id',
            'sort'  => ['attributes' => ['modulename', 'type', 'status', 'priority', 'senddatetime']]
        ]);

        // Validate data
        if (!$this->validate())
        {
            return $dataProvider;
        }
        $query->andFilterWhere(['like', 'modulename',       $this->modulename]);
        $query->andFilterWhere(['like', 'type',             $this->type]);
        $query->andFilterWhere(['like', 'data',             $this->data]);
        $query->andFilterWhere(['like', 'status',           $this->status]);
        $query->andFilterWhere(['like', 'priority',         $this->priority]);
        $query->andFilterWhere(['like', 'senddatetime',     $this->senddatetime]);
        return $dataProvider;
    }
}