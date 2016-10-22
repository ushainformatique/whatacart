<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace newsletter\models;

use yii\base\Model;
use usni\UsniAdaptor;
use usni\library\utils\AdminUtil;
use usni\library\components\TranslatedActiveDataProvider;
/**
 * NewsletterSearch class file
 * This is the search class for model Newsletter.
 * @package newsletter\models
 */
class NewsletterSearch extends Newsletter
{
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
     * @return yii\data\ActiveDataProvider
     */
    public function search()
    {
        $query          = Newsletter::find();
        $query->innerJoinWith('translations');
        $dataProvider   = new TranslatedActiveDataProvider([
            'query' => $query,
        ]);

        // Validate data
        if (!$this->validate())
        {
            return $dataProvider;
        }
        $query->andFilterWhere(['like', 'subject', $this->subject]);
        $query->andFilterWhere(['like', 'content', $this->content]);
        $user     = UsniAdaptor::app()->user->getUserModel();
        if(!AdminUtil::doesUserHaveOthersPermissionsOnModel(Newsletter::className(), $user))
        {
            $query->andFilterWhere([$this->tableName() . '.created_by' => $user->id]);
        }
        return $dataProvider;
    }
}