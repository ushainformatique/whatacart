<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace products\models;

use usni\library\db\ActiveRecord;
use products\models\ProductOption;
use products\models\Product;
use usni\UsniAdaptor;
/**
 * ProductOptionMapping active record.
 *
 * @package products\models
 */
class ProductOptionMapping extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
                    [['product_id', 'option_id', 'required'],  'required'],
                    [['product_id', 'option_id', 'required'],  'safe']
               ];
    }
    
    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        $scenario               = parent::scenarios();
        $scenario['create']     = $scenario['update'] = ['product_id', 'option_id', 'required'];
        return $scenario;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'option_id'         => UsniAdaptor::t('products', 'Option'),
            'product_id'        => Product::getLabel(1),
            'required'          => UsniAdaptor::t('application', 'Required')
        ];
    }

    /**
     * @inheritdoc
     */
    public static function getLabel($n = 1)
    {
        return UsniAdaptor::t('application', 'Manage') . ' ' . ProductOption::getLabel(2);
    }

    /**
     * @inheritdoc
     */
    public function attributeHints()
    {
        return [];
    }
    
    /**
     * Get product options mapping details
     * @return ActiveQuery
     */
    public function getDetails()
    {
        return $this->hasMany(ProductOptionMappingDetails::className(), ['mapping_id' => 'id']);
    }
    
    /**
     * @inheritdoc
     */
    public function beforeDelete()
    {
        if(parent::beforeDelete())
        {
            ProductOptionMappingDetails::deleteAll('mapping_id = :mid', [':mid' => $this->id]);
            return true;
        }
        return false;
    }
}
?>