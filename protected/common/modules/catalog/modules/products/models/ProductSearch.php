<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace products\models;

use usni\library\dataproviders\ArrayRecordDataProvider;
use yii\base\Model;
use usni\UsniAdaptor;
use common\modules\stores\dao\StoreDAO;
/**
 * Product search model.
 * 
 * @package products\models
 */
class ProductSearch extends Product
{
    use \usni\library\traits\SearchTrait;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return Product::tableName();
    }
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
                    [['name', 'model', 'quantity', 'price', 'status'], 'safe'],
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
        $storeId        = UsniAdaptor::app()->storeManager->selectedStoreId;
        $dataCategoryId = StoreDAO::getDataCategoryId($storeId);
        $tableName      = UsniAdaptor::tablePrefix() . 'product';
        $trTableName    = UsniAdaptor::tablePrefix() . 'product_translated';
        $categoryTable  = UsniAdaptor::tablePrefix() . 'product_category';
        $mappingTable   = UsniAdaptor::tablePrefix() . 'product_category_mapping';
        $query          = new \yii\db\Query();
        $query->select('tp.*, tpt.name')
              ->from("$categoryTable tpc,  $mappingTable tpcm, $tableName tp, $trTableName tpt")
              ->where('tpcm.data_category_id = :dci AND tpcm.category_id = tpc.id AND tpcm.product_id = tp.id AND tp.id = tpt.owner_id '
                        . 'AND tpt.language = :lang', 
                     [':dci' => $dataCategoryId, ':lang' => $this->language]);
        if($this->getLimit() != null)
        {
            $query->limit($this->getLimit());
        }
        $dataProvider   = new ArrayRecordDataProvider([
            'query' => $query,
            'key'   => 'id',
            'sort'  => ['attributes' => ['name', 'status', 'price', 'quantity', 'model']]
        ]);

        // Validate data
        if (!$this->validate())
        {
            return $dataProvider;
        }
        $query->andFilterWhere(['like', 'name', $this->name]);
        $query->andFilterWhere(['like', 'model', $this->model]);
        $query->andFilterWhere(['like', 'tp.status', $this->status]);
        $query->andFilterWhere(['like', 'quantity', $this->quantity]);
        $query->andFilterWhere(['like', 'price', $this->price]);
        $query->groupBy('tp.id');
        if($this->canAccessOwnedRecordsOnly('product'))
        {
            $query->andFilterWhere(['tp.created_by' => $this->getUserId()]);
        }
        return $dataProvider;
    }
    
    /**
     * Get the limit for the search
     * @return null|int
     */
    protected function getLimit()
    {
        return null;
    }
}