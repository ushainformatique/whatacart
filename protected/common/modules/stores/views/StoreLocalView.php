<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\stores\views;

use usni\library\views\UiDetailView;
use usni\library\utils\CountryUtil;
use common\modules\localization\modules\currency\utils\CurrencyUtil;
use common\modules\localization\modules\lengthclass\models\LengthClassTranslated;
use usni\UsniAdaptor;
use common\modules\localization\modules\weightclass\models\WeightClassTranslated;
use common\modules\localization\modules\language\utils\LanguageUtil;
/**
 * StoreLocalView class file.
 * @package common\modules\stores\views
 */
class StoreLocalView extends UiDetailView
{
    /**
     * @inheritdoc
     */
    public function getColumns()
    {
        return [
                    ['attribute' => 'country', 'value' => CountryUtil::getCountryName($this->model['country'])],
                    ['attribute' => 'currency', 'value' => $this->getCurrency()],
                    ['attribute' => 'language', 'value' => $this->getLanguage()],
                    ['attribute' => 'length_class', 'value' => $this->getLengthClass()],
                    'state',
                    'timezone',
                    ['attribute' => 'weight_class', 'value' => $this->getWeightClass()]
               ];
    }

    /**
     * @inheritdoc
     */
    protected function shouldRenderTitle()
    {
        return false;
    }

    /**
     * @inheritdoc
     */
    protected static function shouldRenderCreatedAttributes()
    {
        return false;
    }

    /**
     * @inheritdoc
     */
    protected static function shouldRenderModifiedAttributes()
    {
        return false;
    }
    
    /**
     * @inheritdoc
     */
    protected function renderDetailModelBrowseView()
    {
        return null;
    }
    
    /**
     * Get  length class
     * @return string
     */
    protected function getLengthClass()
    {
        $language    = UsniAdaptor::app()->languageManager->getContentLanguage();
        $lengthClass = LengthClassTranslated::find()->where('owner_id = :id AND language = :lang', 
                                                           [':id' => $this->model['length_class'], ':lang' => $language])
                                                    ->asArray()->one();
        if(!empty($lengthClass))
        {
            return $lengthClass['name'];
        }
        return UsniAdaptor::t('application', '(not set)');
    }
    
    /**
     * Get weight class.
     * @return string
     */
    protected function getWeightClass()
    {
        $language    = UsniAdaptor::app()->languageManager->getContentLanguage();
        $weightClass = WeightClassTranslated::find()->where('owner_id = :id AND language = :lang', 
                                                           [':id' => $this->model['weight_class'], ':lang' => $language])
                                                    ->asArray()->one();
        if(!empty($weightClass))
        {
            return $weightClass['name'];
        }
        return UsniAdaptor::t('application', '(not set)');
    }
    
    /**
     * Get currency.
     * @return string
     */
    protected function getCurrency()
    {
        $currency = CurrencyUtil::getCurrencyName($this->model['currency']);
        if(!empty($currency))
        {
            return $currency['name'];
        }
        return UsniAdaptor::t('application', '(not set)');
    }
    
    /**
     * Get language.
     * @return string
     */
    protected function getLanguage()
    {
        $language = LanguageUtil::getLanguageName($this->model['language']);
        if(!empty($language))
        {
            return $language['name'];
        }
        return UsniAdaptor::t('application', '(not set)');
    }
}
?>