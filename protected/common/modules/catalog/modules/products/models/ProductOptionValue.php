<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace products\models;

use usni\library\db\TranslatableActiveRecord;
use usni\UsniAdaptor;
use products\dao\ProductOptionDAO;
/**
 * ProductOptionValue class file.
 *
 * @package products\models
 */
class ProductOptionValue extends TranslatableActiveRecord
{
    /**
     * @inheritdoc
     */
	public function rules()
	{
        return [
                    [['value','option_id'], 'required'],
                    ['value', 'validateValue'],
                    ['value', 'string', 'max' => 128],
                    [['value','option_id'], 'safe'],
               ];
	}
    
    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        $scenario               = parent::scenarios();
        $scenario['update']     = $scenario['create']     = ['value', 'option_id'];
        return $scenario;
    }
    
	/**
     * @inheritdoc
     */
    public static function getLabel($n = 1)
    {
        return ($n == 1) ? UsniAdaptor::t('products', 'Option Value') : UsniAdaptor::t('products', 'Option Values');
    }
    
    /**
     * @inheritdoc
     */
	public function attributeLabels()
	{
		$labels = [
                    'value'      => self::getLabel(1),
                  ];
        return parent::getTranslatedAttributeLabels($labels);
	}
    
    /**
     * @inheritdoc
     */
    public static function getTranslatableAttributes()
    {
        return ['value'];
    }
    
    /**
     * Get option for the value.
     * @return ActiveQuery
     */
    public function getOption()
    {
        return $this->hasOne(ProductOption::className(), ['id' => 'option_id']);
    }
    
    /**
     * Validate name in rules
     * @param string $attribute Attribute
     * @param array  $params
     * @return void
     */
    public function validateValue($attribute, $params)
    {
        if (!$this->hasErrors())
        {
            $language       = $this->language;
            $record         = ProductOptionDAO::getOptionValueRecord($this->value, $this->option_id, $language);
            if ($record !== false)
            {
                $this->addError($attribute, UsniAdaptor::t('products', 'The combination "' . $this->value . '"-"' . $language . '" of Option Value and Language has already been taken for the option.'));
            }
        }
    }
}