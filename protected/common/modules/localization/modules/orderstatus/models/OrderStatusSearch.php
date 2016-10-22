<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\localization\modules\orderstatus\models;

use yii\base\Model;
use usni\library\components\TranslatedActiveDataProvider;
use usni\library\utils\AdminUtil;
use common\modules\localization\modules\orderstatus\models\OrderStatus;
use usni\UsniAdaptor;
/**
 * OrderStatusSearch class file
 * This is the search class for model OrderStatus.
 *
 * @package common\modules\localization\modules\orderstatus\models
 */
class OrderStatusSearch extends OrderStatus
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return OrderStatus::tableName();
    }
    
    /**
     * @inheritdoc
     */
	public function rules()
	{
		return [
                    [['name'],  'safe'],
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
        $query          = OrderStatus::find();
        $tableName      = UsniAdaptor::tablePrefix(). 'order_status';  
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
        if(!AdminUtil::doesUserHaveOthersPermissionsOnModel(OrderStatus::className(), $user))
        {
            $query->andFilterWhere([$tableName . '.created_by' => $user->id]);
        }
        return $dataProvider;
    }
}