<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace products\models;

use yii\base\Model;
use usni\UsniAdaptor;
use usni\library\dataproviders\ArrayRecordDataProvider;
/**
 * ProductAttributeSearch class file
 * This is the search class for model ProductAttribute.
 *
 * @package products\models
 */
class ProductAttributeSearch extends ProductAttribute
{
    use \usni\library\traits\SearchTrait;
    
    /**
     * @inheritdoc
     */
	public function rules()
	{
		return [
                    [['name', 'sort_order', 'attribute_group'], 'safe'],
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
     * Make [[$translationAttributes]] readable
     * @inheritdoc
     */
    public function __get($name)
    {
        if (in_array($name, $this->translationAttributes))
        {
            $model = parent::getTranslation();
            return $model->$name;
        }
        return parent::__get($name);
    }
    
    /**
     * Search based on get params.
     *
     * @return ArrayRecordDataProvider
     */
    public function search()
    {
        $query          = new \yii\db\Query();
        $tableName      = UsniAdaptor::tablePrefix() . 'product_attribute';
        $trTableName    = UsniAdaptor::tablePrefix() . 'product_attribute_translated';
        $query->select('pa.*, pat.name')
              ->from(["$tableName pa"])
              ->innerJoin("$trTableName pat", 'pa.id = pat.owner_id')
              ->where('pat.language = :lang', [':lang' => $this->language]);
        $dataProvider = new ArrayRecordDataProvider([
                                                        'query'     => $query,
                                                        'key'       => 'id',
                                                        'sort'      => ['attributes' => ['name', 'attribute_group', 'sort_order']]
                                                   ]);

        if (!$this->validate()) 
        {
            return $dataProvider;
        }        
        $query->andFilterWhere(['like', 'name', $this->name]);
        $query->andFilterWhere(['attribute_group' => $this->attribute_group]);
        $query->andFilterWhere(['like', 'sort_order', $this->sort_order]);
        if($this->canAccessOwnedRecordsOnly('product'))
        {
            $query->andFilterWhere(['pa.created_by' => $this->getUserId()]);
        }
        return $dataProvider;
    }
    
    /**
     * inheritdoc
     */
    public static function tableName()
    {
        return UsniAdaptor::tablePrefix() . 'product_attribute';
    }
}