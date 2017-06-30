<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\extension\models;

use yii\base\Model;
use usni\UsniAdaptor;
use usni\library\dataproviders\ArrayRecordDataProvider;
/**
 * ExtensionSearch class file
 * 
 * @package common\modules\extension\models
 */
class ExtensionSearch extends Extension
{
    use \usni\library\traits\SearchTrait;
    
    /**
     * @inheritdoc
     */
	public function rules()
	{
		return [
                    [['name', 'author',  'version', 'product_version', 'status', 'category', 'code'],  'safe'],
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
        $tableName      = UsniAdaptor::tablePrefix() . 'extension';
        $trTableName    = UsniAdaptor::tablePrefix() . 'extension_translated';
        $query->select('e.*, et.name')
              ->from(["$tableName e"])
              ->innerJoin("$trTableName et", 'e.id = et.owner_id')
              ->where('et.language = :lang', [':lang' => $this->language]);
        $dataProvider = new ArrayRecordDataProvider([
                                                        'query' => $query,
                                                        'key'   => 'id',
                                                        'sort'  => ['attributes' => ['name', 'code', 'author', 'version', 'product_version', 'status']]
                                                   ]);

        if (!$this->validate()) 
        {
            return $dataProvider;
        }        
        $query->andFilterWhere(['like', 'code', $this->code]);
        $query->andFilterWhere(['category' => $this->category]);
        $query->andFilterWhere(['like', 'name', $this->name]);
        $query->andFilterWhere(['like', 'author', $this->author]);
        $query->andFilterWhere(['version' => $this->version]);
        $query->andFilterWhere(['like', 'product_version', $this->product_version]);
        $query->andFilterWhere(['status' => $this->status]);
        if($this->canAccessOwnedRecordsOnly('extension'))
        {
            $query->andFilterWhere(['e.created_by' => $this->getUserId()]);
        }
        if($this->category == 'payment')
        {
            $models = $dataProvider->getModels();
            foreach($models as $index => $model)
            {
                $managerClass = '\common\modules\\' . $this->category . '\business\\' . $model['code'] . '\Manager';
                $manager      = $managerClass::getInstance();
                $model['allowToDeactivate'] = $manager->checkIfPaymentMethodAllowedToDeactivate();
                $models[$index] = $model;
            }
            $dataProvider->setModels($models);
        }
        elseif($this->category == 'shipping')
        {
            $models = $dataProvider->getModels();
            foreach($models as $index => $model)
            {
                $managerClass = '\common\modules\\' . $this->category . '\business\\' . $model['code'] . '\Manager';
                $manager      = $managerClass::getInstance();
                $model['allowToDeactivate'] = $manager->checkIfShippingMethodAllowedToDeactivate($model['code']);
                $models[$index] = $model;
            }
            $dataProvider->setModels($models);
        }
        return $dataProvider;
    }
    
    /**
     * inheritdoc
     */
    public static function tableName()
    {
        return UsniAdaptor::tablePrefix() . 'extension';
    }
}