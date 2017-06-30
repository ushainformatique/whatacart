<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\cms\models;

use yii\base\Model;
use usni\UsniAdaptor;
use usni\library\dataproviders\ArrayRecordDataProvider;
/**
 * PageSearch class file
 * This is the search class for model Page.
 * 
 * @package common\modules\cms\models
 */
class PageSearch extends Page
{
    use \usni\library\traits\SearchTrait;
    
    /**
     * @inheritdoc
     */
	public function rules()
	{
		return [
                    [['name', 'parent_id',  'status'],  'safe'],
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
        $query          = new \yii\db\Query();
        $tableName      = UsniAdaptor::tablePrefix() . 'page';
        $trTableName    = UsniAdaptor::tablePrefix() . 'page_translated';
        $query->select('tp.*, tpt.name, tpt.alias, tpt.menuitem, tpt.content, tpt.summary, tpt.metakeywords, tpt.metadescription')
              ->from(["$tableName tp"])
              ->innerJoin("$trTableName tpt", 'tp.id = tpt.owner_id')
              ->where('tpt.language = :lang', [':lang' => $this->language])
              ->orderBy('tp.path');
        $dataProvider = new ArrayRecordDataProvider([
                                                        'query'     => $query,
                                                        'key'       => 'id',
                                                        'sort'      => ['attributes' => ['status']]
                                                   ]);

        if (!$this->validate()) 
        {
            return $dataProvider;
        }        
        $query->andFilterWhere(['like', 'name', $this->name]);
        $query->andFilterWhere(['status' => $this->status]);
        if($this->canAccessOwnedRecordsOnly('page'))
        {
            $query->andFilterWhere(['tp.created_by' => $this->getUserId()]);
        }
        return $dataProvider;
    }
    
    /**
     * inheritdoc
     */
    public static function tableName()
    {
        return UsniAdaptor::tablePrefix() . 'page';
    }
}