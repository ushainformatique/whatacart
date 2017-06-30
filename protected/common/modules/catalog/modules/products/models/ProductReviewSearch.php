<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace products\models;

use yii\base\Model;
use usni\UsniAdaptor;
use usni\library\dataproviders\ArrayRecordDataProvider;
use common\modules\stores\dao\StoreDAO;
/**
 * ProductReviewSearch class file.
 *
 * @package products\models
 */
class ProductReviewSearch extends ProductReview
{
    use \usni\library\traits\SearchTrait;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return ProductReview::tableName();
    }
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
                    [['name', 'product_id', 'review', 'status'], 'safe'],
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
        $storeId                = UsniAdaptor::app()->storeManager->selectedStoreId;
        $dataCategoryId         = StoreDAO::getDataCategoryId($storeId);
        $query                  = new \yii\db\Query();
        $tableName              = $this->tableName();
        $trTableName            = UsniAdaptor::tablePrefix() . 'product_review_translated';
        $mappingTable           = UsniAdaptor::tablePrefix() . 'product_category_mapping';
        $productTable           = UsniAdaptor::tablePrefix() . 'product';
        $trProductTable         = UsniAdaptor::tablePrefix() . 'product_translated';
        $query->select('tpr.*, tprt.review, tpt.name AS product_name')
              ->from(["$mappingTable tpcm, $productTable tp, $tableName tpr, $trTableName tprt, $trProductTable tpt"])
              ->where('tpcm.data_category_id = :dci AND tpcm.product_id = tp.id AND tpt.owner_id = tp.id AND tpt.language = :plang AND tp.id = tpr.product_id 
                      AND tpr.status != :status AND tpr.id = tprt.owner_id AND tprt.language = :lang', 
                     [':dci' => $dataCategoryId, ':lang' => $this->language, ':plang' => $this->language, ':status' => self::STATUS_DELETED])
              ->groupBy(['tp.id', 'tpr.id']);
        $dataProvider   = new ArrayRecordDataProvider([
            'query'     => $query,
            'key'       => 'id',
            'sort'      => ['attributes' => ['name', 'review', 'product_id', 'status']]
        ]);

        // Validate data
        if (!$this->validate())
        {
            return $dataProvider;
        }
        $query->andFilterWhere(['like', 'tpr.name', $this->name]);
        $query->andFilterWhere(['like', 'review', $this->review]);
        $query->andFilterWhere(['tpr.product_id' => $this->product_id]);
        $query->andFilterWhere(['tpr.status' => $this->status]);
        if($this->canAccessOwnedRecordsOnly('productreview'))
        {
            $query->andFilterWhere(['tpr.created_by' => $this->getUserId()]);
        }
        return $dataProvider;
    }
}