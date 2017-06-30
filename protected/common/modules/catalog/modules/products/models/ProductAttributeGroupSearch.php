<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace products\models;

use yii\base\Model;
use products\models\ProductAttributeGroup;
use usni\UsniAdaptor;
use usni\library\dataproviders\ArrayRecordDataProvider;
/**
 * ProductAttributeGroupSearch class file
 * This is the search class for model ProductAttributeGroup.
 * 
 * @package products\models
 */
class ProductAttributeGroupSearch extends ProductAttributeGroup
{
    use \usni\library\traits\SearchTrait;
    
    /**
     * @inheritdoc
     */
	public function rules()
	{
		return [
                    [['name', 'sort_order'], 'safe'],
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
        $tableName      = UsniAdaptor::tablePrefix() . 'product_attribute_group';
        $trTableName    = UsniAdaptor::tablePrefix() . 'product_attribute_group_translated';
        $query->select('ag.*, agt.name')
              ->from(["$tableName ag"])
              ->innerJoin("$trTableName agt", 'ag.id = agt.owner_id')
              ->where('agt.language = :lang', [':lang' => $this->language]);
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
        if($this->canAccessOwnedRecordsOnly('product'))
        {
            $query->andFilterWhere(['ag.created_by' => $this->getUserId()]);
        }
        return $dataProvider;
    }
    
    /**
     * inheritdoc
     */
    public static function tableName()
    {
        return UsniAdaptor::tablePrefix() . 'product_attribute_group';
    }
}