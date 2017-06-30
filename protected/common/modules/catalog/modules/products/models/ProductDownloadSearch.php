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
 * ProductDownloadSearch class file
 * This is the search class for model ProductDownload.
 *
 * @package products\models
 */
class ProductDownloadSearch extends ProductDownload
{
    use \usni\library\traits\SearchTrait;
    
    /**
     * @inheritdoc
     */
	public function rules()
	{
		return [
                    [['name', 'file', 'type'], 'safe'],
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
        $tableName      = UsniAdaptor::tablePrefix() . 'product_download';
        $trTableName    = UsniAdaptor::tablePrefix() . 'product_download_translated';
        $query->select('p.*, pt.name')
              ->from(["$tableName p"])
              ->innerJoin("$trTableName pt", 'p.id = pt.owner_id')
              ->where('pt.language = :lang', [':lang' => $this->language]);
        $dataProvider = new ArrayRecordDataProvider([
                                                        'query'     => $query,
                                                        'key'       => 'id',
                                                        'sort'      => ['attributes' => ['name', 'file', 'type']]
                                                   ]);

        if (!$this->validate()) 
        {
            return $dataProvider;
        }        
        $query->andFilterWhere(['like', 'name', $this->name]);
        $query->andFilterWhere(['like', 'file', $this->file]);
        $query->andFilterWhere(['like', 'type', $this->type]);
        if($this->canAccessOwnedRecordsOnly('product'))
        {
            $query->andFilterWhere(['p.created_by' => $this->getUserId()]);
        }
        return $dataProvider;
    }
    
    /**
     * inheritdoc
     */
    public static function tableName()
    {
        return UsniAdaptor::tablePrefix() . 'product_download';
    }
}