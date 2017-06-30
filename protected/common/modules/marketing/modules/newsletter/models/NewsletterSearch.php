<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace newsletter\models;

use yii\base\Model;
use usni\UsniAdaptor;
use usni\library\dataproviders\ArrayRecordDataProvider;
/**
 * NewsletterSearch class file.
 * 
 * This is the search class for model Newsletter.
 * @package newsletter\models
 */
class NewsletterSearch extends Newsletter
{
    use \usni\library\traits\SearchTrait;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return Newsletter::tableName();
    }
    
    /**
     * @inheritdoc
     */
	public function rules()
	{
		return [
                    [['subject', 'content'],       'safe'],
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
     * @return ArrayRecordDataProvider
     */
    public function search()
    {
        $query          = new \yii\db\Query();
        $tableName      = UsniAdaptor::tablePrefix() . 'newsletter';
        $trTableName    = UsniAdaptor::tablePrefix() . 'newsletter_translated';
        $query->select('n.*, nt.content')
              ->from(["$tableName n"])
              ->innerJoin("$trTableName nt", 'n.id = nt.owner_id')
              ->where('nt.language = :lang', [':lang' => $this->language]);
        $dataProvider = new ArrayRecordDataProvider([
                                                        'query'     => $query,
                                                        'key'       => 'id',
                                                        'sort'      => ['attributes' => ['subject', 'content']]
                                                   ]);

        if (!$this->validate()) 
        {
            return $dataProvider;
        }        
        $query->andFilterWhere(['like', 'subject', $this->subject]);
        $query->andFilterWhere(['like', 'content', $this->content]);
        if($this->canAccessOwnedRecordsOnly('newsletter'))
        {
            $query->andFilterWhere(['n.created_by' => $this->getUserId()]);
        }
        return $dataProvider;
    }
}