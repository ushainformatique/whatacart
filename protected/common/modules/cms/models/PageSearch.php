<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\cms\models;

use usni\library\components\TranslatedActiveDataProvider;
use yii\base\Model;
use usni\UsniAdaptor;
use usni\library\utils\AdminUtil;
/**
 * PageSearch class file
 * This is the search class for model Page.
 * 
 * @package common\modules\cms\models
 */
class PageSearch extends Page
{   
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
     * @return yii\data\ActiveDataProvider
     */
    public function search()
    {
        $language       = UsniAdaptor::app()->languageManager->getContentLanguage();
        $query          = Page::find();
        $tableName      = UsniAdaptor::tablePrefix() . 'page';
        $trTableName    = UsniAdaptor::tablePrefix() . 'page_translated';
        $query->select('tp.*, tpt.name, tpt.alias, tpt.menuitem, tpt.content, tpt.summary, tpt.metakeywords, tpt.metadescription')
              ->from(["$tableName tp"])
              ->innerJoin("$trTableName tpt", 'tp.id = tpt.owner_id')
              ->where('tpt.language = :lang', [':lang' => $language]);
        $dataProvider   = new TranslatedActiveDataProvider([
            'query' => $query,
        ]);

        // Validate data
        if (!$this->validate())
        {
            return $dataProvider;
        }
        $query->andFilterWhere(['like', 'name', $this->name]);
        $query->andFilterWhere(['parent_id' => $this->parent_id]);
        $query->andFilterWhere(['status' => $this->status]);
        $user     = UsniAdaptor::app()->user->getUserModel();
        if(!AdminUtil::doesUserHaveOthersPermissionsOnModel(Page::className(), $user))
        {
            $query->andFilterWhere(['tp.created_by' => $user->id]);
        }
        return $dataProvider;
    }
}