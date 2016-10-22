<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\dataCategories\managers;

use usni\library\components\UiDataManager;
use common\modules\dataCategories\models\DataCategory;
use usni\library\components\UiBaseActiveRecord;
use usni\UsniAdaptor;
/**
 * Loads default data related to data category.
 * 
 * @package common\modules\dataCategories\managers
 */
class DataCategoriesDataManager extends UiDataManager
{
    /**
     * @inheritdoc
     */
    public static function getDefaultDataSet()
    {
        return [
                 [
                    'id'           => DataCategory::ROOT_CATEGORY_ID, 
                    'name'         => UsniAdaptor::t('dataCategories', 'Root Category'), 
                    'description'  => 'This is root data category for the application under which all the data would reside',
                    'status'       => UiBaseActiveRecord::STATUS_ACTIVE
                ]
               ];
    }
    
    /**
     * @inheritdoc
     */
    public static function getModelClassName()
    {
        return DataCategory::className();
    }
    
    /**
     * @inheritdoc
     */
    public static function getDefaultDemoDataSet()
    {
        return [];
    }
}