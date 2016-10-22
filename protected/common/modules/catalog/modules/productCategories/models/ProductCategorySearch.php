<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace productCategories\models;

use usni\UsniAdaptor;
use productCategories\dataproviders\ProductCategoryActiveDataProvider;
use yii\base\Model;
use usni\library\utils\AdminUtil;
/**
 * ProductCategorySearch class  file.
 * 
 * @package productCategories\models
 */
class ProductCategorySearch extends ProductCategory
{
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
     * @return productCategories\dataproviders\ProductCategoryActiveDataProvider
     */
    public function search()
    {
        $query          = ProductCategory::find();
        $query->innerJoinWith('translations');
        $dataProvider   = new ProductCategoryActiveDataProvider([
            'query' => $query,
            'filterModel' => $this,
            'filteredColumns' => ['name', 'status', 'created_by', 'parent_id']
        ]);

        // Validate data
        if (!$this->validate())
        {
            return $dataProvider;
        }
        $this->language = UsniAdaptor::app()->languageManager->getContentLanguage();
        $user     = UsniAdaptor::app()->user->getUserModel();
        if(!AdminUtil::doesUserHaveOthersPermissionsOnModel(ProductCategory::className(), $user))
        {
            $this->created_by = $user->id;
        }
        return $dataProvider;
    }
}