<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace taxes\models;

use usni\library\db\TranslatableActiveRecord;
use usni\UsniAdaptor;
use taxes\models\ProductTaxClassTranslated;
use products\dao\ProductDAO;
use taxes\dao\TaxRuleDAO;
use yii\db\Exception;
/**
 * ProductTaxClass active record.
 * 
 * @package taxes\models
 */
class ProductTaxClass extends TranslatableActiveRecord 
{
	/**
     * @inheritdoc
     */
	public function rules()
	{
		return [
                    ['name',            'required'],
                    ['name',            'unique', 'targetClass' => ProductTaxClassTranslated::className(), 'targetAttribute' => ['name', 'language'], 'on' => 'create'],
                    ['name',            'unique', 'targetClass' => ProductTaxClassTranslated::className(), 'targetAttribute' => ['name', 'language'], 'filter' => ['!=', 'owner_id', $this->id], 'on' => 'update'],
                    ['description',     'safe'],
                    ['name',            'string', 'max' => 64],
                    [['id', 'name'],    'safe'],
               ];
	}
    
    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        $scenario               = parent::scenarios();
        $scenario['create']     = $scenario['update'] = ['name', 'description'];
        return $scenario;
    }
    
    /**
     * @inheritdoc
     */
	public function attributeLabels()
	{
		$labels = [
                    'id'					 => UsniAdaptor::t('application', 'Id'),
                    'name'					 => UsniAdaptor::t('application', 'Name'),
                    'description'            => UsniAdaptor::t('application', 'Description')
                  ];
        return parent::getTranslatedAttributeLabels($labels);
	}
    
    /**
     * @inheritdoc
     */
    public static function getLabel($n = 1)
    {
        return ($n == 1) ? UsniAdaptor::t('tax', 'Product Tax Class') : UsniAdaptor::t('tax', 'Product Tax Classes');
    }
    
    /**
     * @inheritdoc
     */
    public static function getTranslatableAttributes()
    {
        return ['name', 'description'];
    }
    
    /**
     * @inheritdoc
     */
    public function beforeDelete()
    {
        $isAllowedToDelete = $this->checkIfAllowedToDelete();
        if(!$isAllowedToDelete)
        {
            throw new Exception('this product tax class is associated with tax rule or product.');
        }
        return parent::beforeDelete();
    }
    
    /**
     * Check if product tax class is allowed to delete.
     * @return boolean
     */
    public function checkIfAllowedToDelete()
    {
        $taxRules   = TaxRuleDAO::getTaxRuleByAttribute('product_tax_class_id', $this->id, $this->language);
        $products   = ProductDAO::getProductsByAttribute('tax_class_id', $this->id, $this->language);
        if(empty($taxRules) && empty($products))
        {
            return true;
        }
        return false;
    }
}