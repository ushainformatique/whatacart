<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace productCategories\models;

use usni\UsniAdaptor;
use yii\base\Model;
use usni\library\dataproviders\ArrayRecordDataProvider;
use common\modules\stores\dao\StoreDAO;
/**
 * ProductCategorySearch class  file.
 * 
 * @package productCategories\models
 */
class ProductCategorySearch extends ProductCategory
{
    use \usni\library\traits\SearchTrait;
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [[['name', 'status', 'created_by', 'image', 'parent_id'], 'safe']];
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
        $dataCategoryId = StoreDAO::getDataCategoryId(UsniAdaptor::app()->storeManager->selectedStoreId);
        $query          = new \yii\db\Query();
        $tableName      = UsniAdaptor::tablePrefix() . 'product_category';
        $trTableName    = UsniAdaptor::tablePrefix() . 'product_category_translated';
        $query->select('tp.*, tpt.name, tpt.alias, tpt.metakeywords, tpt.metadescription, tpt.description')
              ->from(["$tableName tp"])
              ->innerJoin("$trTableName tpt", 'tp.id = tpt.owner_id AND tpt.language = :lang', [':lang' => $this->language])
              ->where('tp.data_category_id = :dc', [':dc' => $dataCategoryId])
              ->orderBy('path');
        $dataProvider = new ArrayRecordDataProvider([
                                                        'query'     => $query,
                                                        'key'       => 'id',
                                                        'sort'      => ['attributes' => ['status']]
                                                   ]);

        if (!$this->validate()) 
        {
            return $dataProvider;
        }        
        $query->andFilterWhere(['like', 'name', $this->name]);
        $query->andFilterWhere(['status' => $this->status]);
        if($this->canAccessOwnedRecordsOnly('productcategory'))
        {
            $query->andFilterWhere(['tp.created_by' => $this->getUserId()]);
        }
        return $dataProvider;
    }
    
    /**
     * inheritdoc
     */
    public static function tableName()
    {
        return UsniAdaptor::tablePrefix() . 'product_category';
    }
}