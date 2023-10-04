<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\modules\auth\models;

use yii\base\Model;
use usni\library\modules\auth\models\Group;
use usni\UsniAdaptor;
use usni\library\dataproviders\ArrayRecordDataProvider;
/**
 * GroupSearch class file
 * This is the search class for model Group.
 * 
 * @package usni\library\modules\auth\models
 */
class GroupSearch extends Group
{
    use \usni\library\traits\SearchTrait;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return Group::tableName();
    }

	/**
     * @inheritdoc
     */
	public function rules()
	{
		return [
                    [['name', 'status', 'parent_id', 'level'], 'safe'],
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
        $table      = UsniAdaptor::tablePrefix(). 'group';
        $query      = new \yii\db\Query();
        $query->select('*')
              ->from(["$table g"])
              ->where('category = :category', [':category' => 'system'])
              ->orderBy('path');
        $dataProvider   = new ArrayRecordDataProvider([
            'query' => $query,
            'key'   => 'id',
            'sort'  => ['attributes' => ['status']]
        ]);

        // Validate data
        if (!$this->validate())
        {
            return $dataProvider;
        }
        $query->andFilterWhere(['like', 'name', $this->name]);
        $query->andFilterWhere(['status' => $this->status]);
        $query->andFilterWhere(['level' => $this->level]);
        if($this->canAccessOwnedRecordsOnly('group'))
        {
            $query->andFilterWhere(['g.created_by' => $this->getUserId()]);
        }
        return $dataProvider;
    }
}