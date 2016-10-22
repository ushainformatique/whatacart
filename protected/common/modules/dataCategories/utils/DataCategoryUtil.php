<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace common\modules\dataCategories\utils;

use usni\UsniAdaptor;
use common\modules\dataCategories\models\DataCategoryTranslated;
use common\modules\stores\models\Store;
use common\modules\dataCategories\models\DataCategory;
/**
 * DataCategoryUtil class file.
 * 
 * @package common\modules\dataCategories\utils
 */
class DataCategoryUtil
{
    /**
     * Get data category.
     * @param int $dataCategoryId
     * @return string
     */
    public static function getDataCategoryById($dataCategoryId)
    {
        if(!empty($dataCategoryId))
        {
            $language       = UsniAdaptor::app()->languageManager->getContentLanguage();
            return DataCategoryTranslated::find()->where('owner_id = :id AND language = :lang', [':id' => $dataCategoryId, 
                                                                                                            ':lang' => $language])->asArray()->one();
        }
        return UsniAdaptor::t('application', '(not set)');
    }
    
    /**
     * Check if stores associated
     * @param Model $model
     * @return boolean
     */
    public static function checkIfAllowedToDelete($model)
    {
        if($model->id == DataCategory::ROOT_CATEGORY_ID)
        {
            \Yii::warning('Root category can not be deleted from the system');
            return false;
        }
        $count = Store::find()->where('data_category_id = :dci', [':dci' => $model->id])->count();
        \Yii::info('Count of stores is ' . $count);
        if($count > 0)
        {
            \Yii::warning('Delete failed as stores are associated to data category');
            return false;
        }
        return true;
    }
}