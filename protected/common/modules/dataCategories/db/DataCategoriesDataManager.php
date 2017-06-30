<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\dataCategories\db;

use usni\library\db\DataManager;
use common\modules\dataCategories\models\DataCategory;
use usni\library\db\ActiveRecord;
use usni\UsniAdaptor;
/**
 * Loads default data related to data category.
 * 
 * @package common\modules\dataCategories\db
 */
class DataCategoriesDataManager extends DataManager
{
    /**
     * @inheritdoc
     */
    public function getDefaultDataSet()
    {
        return [
                 [
                    'id'           => DataCategory::ROOT_CATEGORY_ID, 
                    'name'         => UsniAdaptor::t('dataCategories', 'Root Category'), 
                    'description'  => UsniAdaptor::t('dataCategories', 'This is root data category for the application under which all the data would reside'),
                    'status'       => ActiveRecord::STATUS_ACTIVE
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
}