<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace products\models;

use usni\library\components\TranslatableActiveRecord;
use usni\UsniAdaptor;
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
            $language       = UsniAdaptor::app()->languageManager->getContentLanguage();
            $tableName      = UsniAdaptor::tablePrefix(). 'product_option_value';
            $trTableName    = UsniAdaptor::tablePrefix(). 'product_option_value_translated';
            $sql            = "SELECT * FROM $tableName pov, $trTableName povt WHERE povt.value = :value AND povt.owner_id = pov.id "
                               . "AND povt.language = :lan AND pov.option_id = :optionId";
            $record         = UsniAdaptor::app()->db->createCommand($sql, [':value' => $this->value, ':lan' => $language, 
                              ':optionId' => $this->option_id])->queryOne();
            if ($record !== false)
            {
                $this->addError($attribute, UsniAdaptor::t('products', 'The combination "' . $this->value . '"-"' . $language . '" of Option Value and Language has already been taken for the option.'));
            }
        }
    }
}