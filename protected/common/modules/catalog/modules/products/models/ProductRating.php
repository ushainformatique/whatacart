<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace products\models;

use usni\UsniAdaptor;
use products\models\Product;

/**
 * This is the model class for table "product_rating".
 * 
 * @package products\models
 */
class ProductRating extends \usni\library\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
                  [['product_id'], 'required'],
                  ['rating', 'number', 'integerOnly' => false],
                  ['rating', 'default', 'value' => 0],
                  [['rating', 'product_id'], 'safe'],
               ];
    }
    
    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        $scenario = parent::scenarios();
        $scenario['create']  = ['rating', 'product_id'];
        return $scenario;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
                    'rating'           => UsniAdaptor::t('products', 'Rating'),
               ];
    }

    /**
     * @inheritdoc
     */
    public static function getLabel($n = 1)
    {
        return ($n == 1) ? UsniAdaptor::t('products', 'Rating') : UsniAdaptor::t('products', 'Ratings');
    }
    
    /**
     * Get product.
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
       return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }
}