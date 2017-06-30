<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace common\modules\localization\modules\state\business;

use common\modules\localization\modules\country\models\CountryTranslated;
use usni\library\utils\ArrayUtil;
use common\modules\localization\modules\state\dao\StateDAO;
use yii\base\InvalidParamException;
use usni\UsniAdaptor;
use common\modules\localization\modules\state\models\State;
use common\modules\localization\modules\state\models\StateTranslated;
use common\modules\localization\modules\country\behaviors\CountryBehavior;
/**
 * FormDTO class file.
 * 
 * @package common\modules\localization\modules\state\business
 */
class Manager extends \usni\library\business\Manager
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            CountryBehavior::className()
        ];
    }
    
    /**
     * inheritdoc
     */
    public function processEdit($formDTO)
    {
        parent::processEdit($formDTO);
        $data = $this->getCountryDropdownData();
        $formDTO->setCountryDropdownData($data);
    }
    
    /**
     * inheritdoc
     */
    public function getBrowseModels($modelClass)
    {
        return StateDAO::getAll($this->language, State::STATUS_ACTIVE);
    }
    
    /**
     * inheritdoc
     */
    public function processList($gridViewDTO)
    {
        parent::processList($gridViewDTO);
        $data = $this->getCountryDropdownData();
        $gridViewDTO->setCountryDropdownData($data);
    }
    
    /**
     * inheritdoc
     */
    public function loadModel($modelClass, $id)
    {
        $model      = StateDAO::getById($id, $this->language);
        if ($model === null)
        {
            throw new InvalidParamException("Id is not valid: $id");
        }
        //Get country
        $country = CountryTranslated::find()->where('id = :id AND language = :lang', [':id' => $model['country_id'], 
                                                    ':lang' => $this->language])->asArray()->one();
        $model['country'] = $country['name'];
        return $model;
    }
    
    /**
     * Process get state by country.
     * 
     * @param integer  $countryId
     * @return string
     */
    public function processGetStateByCountry($countryId)
    {
        $str            = null;
        $dropdownData   = $this->getStatesOptionByCountryId($countryId);
        foreach($dropdownData as $id => $value)
        {
            $str .= "<option value='{$id}'>{$value}</option>";
        }
        return $str;
    }
    
    /**
     * Get states by country id.
     * @param int $countryId
     * @return array
     */
    public function getStatesOptionByCountryId($countryId)
    {
        $str    = null;
        $states = StateDAO::getStateByCountry($countryId, $this->language);
        $dropdownData = ArrayUtil::map($states, 'id', 'name');
        return ArrayUtil::merge([-1 => UsniAdaptor::t('localization', 'All States')], $dropdownData);
    }
    
    /**
     * Gets country and all country drop down data.
     * @return array
     */
    public static function getStateAndAllStatesDropdownData()
    {
        $data       = ArrayUtil::map(StateTranslated::find()->asArray()->indexBy('name')->all(), 'owner_id', 'name');
        $data[-1]    = UsniAdaptor::t('localization', 'All States');
        return $data;
    }
}
