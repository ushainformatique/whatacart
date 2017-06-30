<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace taxes\models;

use yii\base\Model;
use usni\UsniAdaptor;
use usni\library\dataproviders\ArrayRecordDataProvider;
/**
 * ProductTaxClassSearch class file
 * This is the search class for model ProductTaxClass.
 *
 * @package taxes\models
 */
class ProductTaxClassSearch extends ProductTaxClass
{
    use \usni\library\traits\SearchTrait;
    
	/**
     * @inheritdoc
     */
    public static function tableName()
    {
        return ProductTaxClass::tableName();
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
        $tableName      = UsniAdaptor::tablePrefix() . 'product_tax_class';
        $trTableName    = UsniAdaptor::tablePrefix() . 'product_tax_class_translated';
        $query->select('p.*, pt.name')
              ->from(["$tableName p"])
              ->innerJoin("$trTableName pt", 'p.id = pt.owner_id')
              ->where('pt.language = :lang', [':lang' => $this->language]);
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
        if($this->canAccessOwnedRecordsOnly('producttaxclass'))
        {
            $query->andFilterWhere(['p.created_by' => $this->getUserId()]);
        }
        return $dataProvider;
    }
}