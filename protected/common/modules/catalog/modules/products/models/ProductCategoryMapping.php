<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace products\models;

use usni\library\db\ActiveRecord;;
/**
 * ProductCategoryMapping active record.
 *
 * @package products\models
 */
class ProductCategoryMapping extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
                    [['product_id', 'category_id', 'data_category_id'],  'required'],
                    [['product_id', 'category_id', 'data_category_id'],  'safe']
               ];
    }
    
    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        $scenario               = parent::scenarios();
        $scenario['create']     = $scenario['update'] = ['product_id', 'category_id', 'data_category_id'];
        return $scenario;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [];
    }

    /**
     * @inheritdoc
     */
    public static function getLabel($n = 1)
    {
        return null;
    }

     /**
     * Get attribute hints.
     * return array
     */
    public function attributeHints()
    {
        return array();
    }
    
    /**
     * inheritdoc
     */
    public function shouldAddCreatedAndModifiedFields()
    {
        return false;
    }
}