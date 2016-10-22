<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace products\models;

use usni\library\components\TranslatedActiveDataProvider;
use yii\base\Model;
use usni\library\utils\AdminUtil;
use usni\UsniAdaptor;
/**
 * ProductReviewSearch class file.
 *
 * @package products\models
 */
class ProductReviewSearch extends ProductReview
{
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
     * @return usni\library\components\TranslatedActiveDataProvider
     */
    public function search()
    {
        $currentStore           = UsniAdaptor::app()->storeManager->getCurrentStore();
        $language               = UsniAdaptor::app()->languageManager->getContentLanguage();
        $query                  = ProductReview::find();
        $tableName              = $this->tableName();
        $trTableName            = UsniAdaptor::tablePrefix() . 'product_review_translated';
        $mappingTable           = UsniAdaptor::tablePrefix() . 'product_category_mapping';
        $productTable           = UsniAdaptor::tablePrefix() . 'product';
        $query->select('tpr.*, tprt.review')
              ->from(["$mappingTable tpcm, $productTable tp, $tableName tpr, $trTableName tprt"])
              ->where('tpcm.data_category_id = :dci AND tpcm.product_id = tp.id AND tp.id = tpr.product_id 
                      AND tpr.id = tprt.owner_id AND tprt.language = :lang', 
                     [':dci' => $currentStore->data_category_id, ':lang' => $language])
              ->groupBy(['tp.id', 'tpr.id']);
        $dataProvider   = new TranslatedActiveDataProvider([
            'query' => $query,
        ]);

        // Validate data
        if (!$this->validate())
        {
            return $dataProvider;
        }
        $query->andFilterWhere(['like', 'name', $this->name]);
        $query->andFilterWhere(['like', 'review', $this->review]);
        $query->andFilterWhere(['tpr.product_id' => $this->product_id]);
        $query->andFilterWhere(['tpr.status' => $this->status]);
        $user     = UsniAdaptor::app()->user->getUserModel();
        if(!AdminUtil::doesUserHaveOthersPermissionsOnModel(Product::className(), $user))
        {
            $query->andFilterWhere(['tpr.created_by' => $user->id]);
        }
        return $dataProvider;
    }
}