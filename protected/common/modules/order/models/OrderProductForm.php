<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */ 
namespace common\modules\order\models;

use yii\base\Model;
use usni\UsniAdaptor;
use products\models\Product;
/**
 * OrderProductForm class file
 *
 * @package common\modules\order\models
 */
class OrderProductForm extends Model
{
    /**
     * Product for the order
     * @var int 
     */
    public $product_id;
    
    /**
     * Quantity for the product
     * @var int 
     */
    public $quantity;
    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'product_id' => Product::getLabel(1),
            'quantity'   => UsniAdaptor::t('products', 'Quantity')
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_id', 'quantity'], 'number', 'integerOnly' => true]
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        $scenarios  = parent::scenarios();
        $scenarios['create'] = ['product_id', 'quantity'];
        return $scenarios;
    }
    
    /**
     * @inheritdoc
     */
    public static function getLabel($n = 1)
    {
        return UsniAdaptor::t('products', 'Product Details');
    }
}