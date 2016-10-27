<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace frontend\views\common;

use usni\UsniAdaptor;
use common\modules\stores\utils\StoreUtil;
use usni\library\components\LanguageManager;
/**
 * LanguageSelectionView class file.
 * 
 * @package frontend\views\commmon
 */
class LanguageSelectionView extends \common\modules\localization\modules\language\views\LanguageSelectionView
{ 
    /**
     * @inheritdoc
     */
    public function getActionUrl()
    {
        return UsniAdaptor::createUrl('customer/site/change-language');
    }
    
    /**
     * @inheritdoc
     */
    protected function getData()
    {
        $data       = LanguageManager::getList();
        $lanData    = [];
        foreach($data as $code => $value)
        {
            $count = StoreUtil::getStoreCountByLanguage($code);
            if($count > 0)
            {
                $lanData[$code] = $value;
            }
        }
        return $lanData;
    }
}