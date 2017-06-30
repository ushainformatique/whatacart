<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace products\models;

use products\models\Product;
use products\models\ProductTranslated;
use usni\UsniAdaptor;
use usni\library\dataproviders\ArrayRecordDataProvider;
use common\modules\stores\dao\StoreDAO;
/**
 * LatestProductSearch to get the latest product added.
 *
 * @package products\models
 */
class LatestProductSearch extends ProductSearch
{
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
    protected function resolveTranslatedModelClassName()
    {
        return ProductTranslated::className();
    }
    
    /**
     * @inheritdoc
     */
    public function search()
    {
        $dataCategoryId = StoreDAO::getDataCategoryId(UsniAdaptor::app()->storeManager->selectedStoreId);
        $tableName      = UsniAdaptor::tablePrefix() . 'product';
        $trTableName    = UsniAdaptor::tablePrefix() . 'product_translated';
        $categoryTable  = UsniAdaptor::tablePrefix() . 'product_category';
        $mappingTable   = UsniAdaptor::tablePrefix() . 'product_category_mapping';
        $query          = new \yii\db\Query();
        $query->select('tp.*, tpt.name')
              ->from("$categoryTable tpc,  $mappingTable tpcm, $tableName tp, $trTableName tpt")
              ->where('tpcm.data_category_id = :dci AND tpcm.category_id = tpc.id AND tpcm.product_id = tp.id AND tp.id = tpt.owner_id '
                        . 'AND tpt.language = :lang', 
                     [':dci' => $dataCategoryId, ':lang' => $this->language])
              ->orderBy('tp.created_datetime DESC')
              ->limit(5);
        $dataProvider   = new ArrayRecordDataProvider([
            'query' => $query,
            'key'   => 'id',
        ]);

        // Validate data
        if (!$this->validate())
        {
            return $dataProvider;
        }
        $query->groupBy('tp.id');
        if($this->canAccessOwnedRecordsOnly('product'))
        {
            $query->andFilterWhere(['tp.created_by' => $this->getUserId()]);
        }
        $dataProvider->setPagination(false);
        return $dataProvider;
    }
}
