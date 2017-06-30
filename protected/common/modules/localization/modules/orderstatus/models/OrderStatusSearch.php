<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\localization\modules\orderstatus\models;

use yii\base\Model;
use common\modules\localization\modules\orderstatus\models\OrderStatus;
use usni\UsniAdaptor;
use usni\library\dataproviders\ArrayRecordDataProvider;
/**
 * OrderStatusSearch class file
 * This is the search class for model OrderStatus.
 *
 * @package common\modules\localization\modules\orderstatus\models
 */
class OrderStatusSearch extends OrderStatus
{
    use \usni\library\traits\SearchTrait;
    
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
     * @return ArrayRecordDataProvider
     */
    public function search()
    {
        $query          = new \yii\db\Query();
        $tableName      = UsniAdaptor::tablePrefix() . 'order_status';
        $trTableName    = UsniAdaptor::tablePrefix() . 'order_status_translated';
        $query->select('o.*, ot.name')
              ->from(["$tableName o"])
              ->innerJoin("$trTableName ot", 'o.id = ot.owner_id')
              ->where('ot.language = :lang', [':lang' => $this->language]);
        $dataProvider = new ArrayRecordDataProvider([
                                                        'query'     => $query,
                                                        'key'       => 'id',
                                                        'sort'      => ['attributes' => ['name']]
                                                   ]);

        if (!$this->validate()) 
        {
            return $dataProvider;
        }        
        $query->andFilterWhere(['like', 'name', $this->name]);
        if($this->canAccessOwnedRecordsOnly('orderstatus'))
        {
            $query->andFilterWhere(['o.created_by' => $this->getUserId()]);
        }
        return $dataProvider;
    }
}