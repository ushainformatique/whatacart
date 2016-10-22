<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace taxes\models;

use yii\base\Model;
use usni\library\components\TranslatedActiveDataProvider;
use usni\library\utils\AdminUtil;
use usni\UsniAdaptor;
/**
 * ProductTaxClassSearch class file
 * This is the search class for model ProductTaxClass.
 *
 * @package taxes\models
 */
class ProductTaxClassSearch extends ProductTaxClass
{
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
     * @return yii\data\ActiveDataProvider
     */
    public function search()
    {
        $query          = ProductTaxClass::find();
        $tableName      = UsniAdaptor::tablePrefix() . 'product_tax_class';
        $query->innerJoinWith('translations');
        $dataProvider   = new TranslatedActiveDataProvider([
            'query' => $query,
        ]);

        // Validate data
        if (!$this->validate())
        {
            return $dataProvider;
        }
        $query->andFilterWhere(['language' => UsniAdaptor::app()->languageManager->getContentLanguage()]);
        $query->andFilterWhere(['like', 'name', $this->name]);
        $user     = UsniAdaptor::app()->user->getUserModel();
        if(!AdminUtil::doesUserHaveOthersPermissionsOnModel(ProductTaxClass::className(), $user))
        {
            $query->andFilterWhere([$tableName . '.created_by' => $user->id]);
        }
        return $dataProvider;
    }
}