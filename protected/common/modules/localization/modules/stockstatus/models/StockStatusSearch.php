<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\localization\modules\stockstatus\models;

use yii\base\Model;
use usni\library\components\TranslatedActiveDataProvider;
use usni\library\utils\AdminUtil;
use usni\UsniAdaptor;
/**
 * StockStatusSearch class file
 * This is the search class for model StockStatus.
 *
 * @package common\modules\localization\modules\stockstatus\models
 */
class StockStatusSearch extends StockStatus
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return StockStatus::tableName();
    }

	/**
     * @inheritdoc
     */
	public function rules()
	{
		return [
                    [['name'], 'safe'],
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
        $query          = StockStatus::find();
        $tableName      = UsniAdaptor::tablePrefix() . 'stock_status';
        $query->innerJoinWith('translations');
        $dataProvider   = new TranslatedActiveDataProvider([
            'query' => $query,
        ]);

        // Validate data
        if (!$this->validate())
        {
            return $dataProvider;
        }
        $query->andFilterWhere(['language' => UsniAdaptor::app()->languageManager->getContentLanguage()]);
        $query->andFilterWhere(['like', 'name', $this->name]);
        $user     = UsniAdaptor::app()->user->getUserModel();
        if(!AdminUtil::doesUserHaveOthersPermissionsOnModel(StockStatus::className(), $user))
        {
            $query->andFilterWhere([$tableName . '.created_by' => $user->id]);
        }
        return $dataProvider;
    }
}