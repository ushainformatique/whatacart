<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace products\models;

use usni\library\db\ActiveRecord;
/**
 * ProductRelatedproductMapping active record.
 * 
 * @package products\models
 */
class ProductRelatedProductMapping extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
                    [['product_id', 'related_product_id'],  'required'],
                    [['product_id', 'related_product_id'],  'safe']
              ];
    }
    
    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        $scenario               = parent::scenarios();
        $scenario['create']     = $scenario['update'] = ['product_id', 'related_product_id'];
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
}
?>