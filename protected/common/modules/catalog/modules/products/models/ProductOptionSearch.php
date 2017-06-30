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
 * ProductOptionSearch class file
 * This is the search class for model ProductOption.
 *
 * @package products\models
 */
class ProductOptionSearch extends ProductOption
{
    use \usni\library\traits\SearchTrait;
    
    /**
     * @inheritdoc
     */
	public function rules()
	{
		return [
                    [['name', 'display_name'], 'safe'],
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
        $tableName      = UsniAdaptor::tablePrefix() . 'product_option';
        $trTableName    = UsniAdaptor::tablePrefix() . 'product_option_translated';
        $query->select('po.*, pot.name, pot.display_name')
              ->from(["$tableName po"])
              ->innerJoin("$trTableName pot", 'po.id = pot.owner_id')
              ->where('pot.language = :lang', [':lang' => $this->language]);
        $dataProvider = new ArrayRecordDataProvider([
                                                        'query'     => $query,
                                                        'key'       => 'id',
                                                        'sort'      => ['attributes' => ['name', 'display_name']]
                                                   ]);

        if (!$this->validate()) 
        {
            return $dataProvider;
        }        
        $query->andFilterWhere(['like', 'name', $this->name]);
        $query->andFilterWhere(['like', 'display_name', $this->display_name]);
        if($this->canAccessOwnedRecordsOnly('product'))
        {
            $query->andFilterWhere(['po.created_by' => $this->getUserId()]);
        }
        return $dataProvider;
    }
    
    /**
     * inheritdoc
     */
    public static function tableName()
    {
        return UsniAdaptor::tablePrefix() . 'product_option';
    }
}