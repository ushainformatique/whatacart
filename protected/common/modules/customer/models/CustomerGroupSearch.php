<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace customer\models;

use usni\UsniAdaptor;
use usni\library\dataproviders\ArrayRecordDataProvider;
use usni\library\modules\auth\models\GroupSearch;
/**
 * CustomerGroupSearch class file
 *
 * @package customer\models
 */
class CustomerGroupSearch extends GroupSearch
{
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
              ->where('category = :category', [':category' => 'customer'])
              ->orderBy('path');
        $dataProvider   = new ArrayRecordDataProvider([
            'query' => $query,
            'key'   => 'id',
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
    
    /**
     * inheritdoc
     */
    public static function tableName()
    {
        return UsniAdaptor::tablePrefix() . 'group';
    }
}
