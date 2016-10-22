<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
/**
 * This is the model class for table "tbl_taxrule_metadata".
 *
 * The followings are the available columns in table 'tbl_taxrule_metadata':
 * @property integer $taxrule_id
 * @property integer $id
 * @property integer $tax_zone_id
 * @property integer $customer_tax_class_id
 * @property integer $product_tax_class_id
 * @property integer $tax_rate_id
 * TaxRule class file
 * @package application.modules.tax.models
 */
class TaxRuleMetadata extends UiSecuredActiveRecord 
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TaxRule the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_taxrule_metadata';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('taxrule_id, customer_tax_class_id, product_tax_class_id, tax_rate_id', 'required'),
			array('tax_zone_id, customer_tax_class_id, product_tax_class_id, tax_rate_id', 'numerical', 'integerOnly'=>true),
			array('tax_zone_id, customer_tax_class_id, product_tax_class_id, tax_rate_id', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		$labels = array(
			'taxrule_id'		     => getLabel('application', 'id'),
			'tax_zone_id'			 => getLabel('tax',   'tax_zone'),
			'customer_tax_class_id'	 => getLabel('tax',   'customer_tax_class'),
			'product_tax_class_id'	 => getLabel('tax',   'product_tax_class'),
			'tax_rate_id'			 => getLabel('tax',   'tax_rate'),
		);
        return parent::getTranslatedAttributeLabels($labels);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('taxrule_id',            $this->taxrule_id);
		$criteria->compare('tax_zone_id',           $this->tax_zone_id);
		$criteria->compare('customer_tax_class_id', $this->customer_tax_class_id);
		$criteria->compare('product_tax_class_id',  $this->product_tax_class_id);
		$criteria->compare('tax_rate_id',           $this->tax_rate_id);
		$criteria->compare('tax_based_on',          $this->tax_based_on,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
    
    /**
     * Get the label for the model.
     * @param $n index to get singular or plural label
     * @return string
     */
    public static function getLabel($n = 1)
    {
        return getLabel('ecommerce','taxrule', array($n));
    }
    
}