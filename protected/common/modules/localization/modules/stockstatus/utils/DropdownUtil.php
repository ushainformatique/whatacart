<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\localization\modules\stockstatus\utils;

use common\modules\localization\modules\stockstatus\models\StockStatus;
use usni\UsniAdaptor;
use yii\helpers\ArrayHelper;
/**
 * Contains dropdown functions.
 * 
 * @package common\modules\localization\modules\stockstatus\utils
 */
class DropdownUtil
{
    /**
     * Gets list of options.
     * @return array
     */
    public static function getList()
    {
        $language   = UsniAdaptor::app()->languageManager->getContentLanguage();
        $data       = StockStatus::find()->innerJoinWith('translations')->where('language = :lan', [':lan' => $language])->all();
        return ArrayHelper::map($data, 'id', 'name');
    }
}