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
 * Product search model.
 * 
 * @package products\models
 */
class ProductSearch extends Product
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
    public function rules()
    {
        return [
                    [['name', 'model', 'quantity', 'price', 'status', 'categories'], 'safe'],
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
        $currentStore   = UsniAdaptor::app()->storeManager->getCurrentStore();
        $language       = UsniAdaptor::app()->languageManager->getContentLanguage();
        $query          = Product::find();
        $tableName      = $this->tableName();
        $trTableName    = UsniAdaptor::tablePrefix() . 'product_translated';
        $categoryTable  = UsniAdaptor::tablePrefix() . 'product_category';
        $mappingTable   = UsniAdaptor::tablePrefix() . 'product_category_mapping';
        
        $query->select('tp.*, tpt.name')
              ->from(["$categoryTable tpc,  $mappingTable tpcm, $tableName tp, $trTableName tpt"])
              ->where('tpcm.data_category_id = :dci AND tpcm.category_id = tpc.id AND tpcm.product_id = tp.id AND tp.id = tpt.owner_id '
                        . 'AND tpt.language = :lang', 
                     [':dci' => $currentStore->data_category_id, ':lang' => $language]);
        $dataProvider   = new TranslatedActiveDataProvider([
            'query' => $query,
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
        $query->andFilterWhere(['category_id' => $this->categories]);
        $query->andFilterWhere(['like', 'price', $this->price]);
        $query->groupBy('tp.id');
        $query->orderBy('tpt.name');
        $user     = UsniAdaptor::app()->user->getUserModel();
        if(!AdminUtil::doesUserHaveOthersPermissionsOnModel(Product::className(), $user))
        {
            $query->andFilterWhere(['tp.created_by' => $user->id]);
        }
        return $dataProvider;
    }
}