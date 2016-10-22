<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\localization\modules\stockstatus\models;

use usni\library\components\TranslatableActiveRecord;
use usni\UsniAdaptor;
use common\modules\localization\modules\stockstatus\utils\StockStatusUtil;
use common\modules\localization\modules\stockstatus\models\StockStatusTranslated;
/**
 * StockStatus class file
 * 
 * @package common\modules\localization\modules\stockstatus\models
 */
class StockStatus extends TranslatableActiveRecord
{
	/**
     * @inheritdoc
     */
	public function rules()
	{
		return [
                    ['name',    'required'],
                    ['name',            'unique', 'targetClass' => StockStatusTranslated::className(), 'targetAttribute' => ['name', 'language'], 'on' => 'create'],
                    ['name',            'unique', 'targetClass' => StockStatusTranslated::className(), 'targetAttribute' => ['name', 'language'], 'filter' => ['!=', 'owner_id', $this->id], 'on' => 'update'],
                    ['name',    'string', 'max' => 128],
                    ['name',    'safe'],
               ];
	}

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios['create'] = $scenarios['update'] = ['name'];
        return $scenarios;
    }

	/**
     * @inheritdoc
     */
	public function attributeLabels()
	{
		$labels = [
                        'id'    => UsniAdaptor::t('application', 'id'),
                        'name'	=> UsniAdaptor::t('application', 'Name'),
                    ];
        return parent::getTranslatedAttributeLabels($labels);
	}

	/**
     * @inheritdoc
     */
    public static function getLabel($n = 1)
    {
        return UsniAdaptor::t('stockstatus', 'Stock Status');
    }
    
     /**
     * @inheritdoc
     */
    public static function getTranslatableAttributes()
    {
        return ['name'];
    }
    
    /**
     * @inheritdoc
     */
    public function beforeDelete()
    {
        if(parent::beforeDelete())
        {
            return StockStatusUtil::checkIfAllowedToDelete($this);
        }        
        return false;
    }
}