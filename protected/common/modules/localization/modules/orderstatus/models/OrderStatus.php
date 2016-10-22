<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\localization\modules\orderstatus\models;

use usni\library\components\TranslatableActiveRecord;
use usni\UsniAdaptor;
use common\modules\localization\modules\orderstatus\models\OrderStatusTranslated;
use common\modules\localization\modules\orderstatus\utils\OrderStatusUtil;
/**
 * OrderStatus active record.
 * 
 * @package common\modules\localization\modules\orderstatus\models
 */
class OrderStatus extends TranslatableActiveRecord 
{   
    /**
     * @inheritdoc
     */
	public function rules()
	{
		return [
                    [['name'],          'required'],
                    ['name',            'unique', 'targetClass' => OrderStatusTranslated::className(), 'targetAttribute' => ['name', 'language'], 'on' => 'create'],
                    ['name',            'unique', 'targetClass' => OrderStatusTranslated::className(), 'targetAttribute' => ['name', 'language'], 'filter' => ['!=', 'owner_id', $this->id], 'on' => 'update'],
                    ['name',            'string', 'max' => 64],
                    [['id', 'name'],    'safe'],
               ];
	}
    
    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios['create'] = $scenarios['update'] = ['id', 'name'];
        return $scenarios;
    }

	/**
     * @inheritdoc
     */
	public function attributeLabels()
	{
		$labels = [
                     'name'             => UsniAdaptor::t('application', 'Name'),
                  ];
        return parent::getTranslatedAttributeLabels($labels);
	}
    
    /**
     * @inheritdoc
     */
    public static function getLabel($n = 1)
    {
        return UsniAdaptor::t('orderstatus', 'Order Status');
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
            return OrderStatusUtil::checkIfAllowedToDelete($this);
        }        
        return false;
    }
}