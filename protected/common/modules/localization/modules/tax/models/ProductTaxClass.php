<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace taxes\models;

use usni\library\components\TranslatableActiveRecord;
use usni\UsniAdaptor;
use taxes\models\ProductTaxClassTranslated;
use taxes\utils\TaxUtil;
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
        if(parent::beforeDelete())
        {
            return TaxUtil::checkIfProductTaxClassAllowedToDelete($this);
        }
        return false;
    }
}