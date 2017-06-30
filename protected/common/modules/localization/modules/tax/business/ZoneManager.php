<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace taxes\business;

use usni\library\business\Manager;
use yii\base\InvalidParamException;
use taxes\dao\ZoneDAO;
use usni\UsniAdaptor;
use common\modules\localization\modules\state\business\Manager as StateBusinessManager;
use usni\library\utils\ArrayUtil;
use common\modules\localization\modules\country\dao\CountryDAO;
use common\modules\localization\modules\state\dao\StateDAO;
use common\modules\localization\modules\country\behaviors\CountryBehavior;
/**
 * ZoneManager class file.
 * 
 * @package taxes\business
 */
class ZoneManager extends Manager
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
    public function getBrowseModels($modelClass)
    {
        return ZoneDAO::getAll($this->language);
    }
    
    /**
     * inheritdoc
     */
    public function loadModel($modelClass, $id)
    {
        $model  = ZoneDAO::getById($id, $this->language);
        if ($model === null)
        {
            throw new InvalidParamException("Id is not valid: $id");
        }
        if($model['country_id'] != -1)
        {
            $countryData        = CountryDAO::getById($model['country_id'], $this->language);
            $model['country']   = $countryData['name'];
        }
        else
        {
            $model['country']   = UsniAdaptor::t('localization', 'All Countries');
        }
        if($model['state_id'] != -1)
        {
            $stateData          = StateDAO::getById($model['state_id'], $this->language);
            $model['state']     = $stateData['name'];
        }
        else
        {
            $model['state']     = UsniAdaptor::t('localization', 'All States');
        }
        $zip                = $this->getZip($model);
        $model['zip']       = $zip;
        return $model;
    }
    
    /**
     * inheritdoc
     */
    public function processEdit($formDTO)
    {
        parent::processEdit($formDTO);
        //Set country dropdown data.
        $countryData = $this->fetchCountryDropdownData();
        $formDTO->setCountryDropdownData($countryData);
        if($formDTO->getModel()->is_zip_range == null)
        {
            $formDTO->getModel()->is_zip_range = 0;
        }
        //Set state dropdown data.
        $stateData = $this->getStateDropdownData($formDTO->getModel());
        $formDTO->setStateDropdownData($stateData);
    }
    
    /**
     * Get country dropdown data.
     * @return array
     */
    public function fetchCountryDropdownData()
    {
        $countries          = $this->getCountryDropdownData();
        $countryData[-1]    = UsniAdaptor::t('localization', 'All Countries');
        return ArrayUtil::merge($countryData, $countries);
    }
    
    /**
     * Get state dropdown data.
     * @param Zone $model
     * @return array
     */
    public function getStateDropdownData($model)
    {
        //States
        if($model['country_id'] == -1)
        {
            $stateData[-1] = UsniAdaptor::t('localization', 'All States');
        }
        else
        {
            $stateData = StateBusinessManager::getInstance()->getStatesOptionByCountryId($model['country_id']);
        }
        return $stateData;
    }
    
    /**
     * inheritdoc
     */
    public function processList($gridViewDTO)
    {
        parent::processList($gridViewDTO);
        //Set country dropdown data.
        $countryData = $this->fetchCountryDropdownData();
        $gridViewDTO->setCountryDropdownData($countryData);
        //Set state dropdown data.
        $stateData = StateBusinessManager::getInstance()->getStateAndAllStatesDropdownData($this->language);
        $gridViewDTO->setStateDropdownData($stateData);
    }
    
    /**
     * Get zip.
     * @param Zone $zone
     * @return string
     */
    public function getZip($zone)
    {
        if($zone['is_zip_range'] == false && $zone['zip'] != null)
        {
            return $zone['zip'];
        }
        elseif($zone['is_zip_range'] == true)
        {
            return UsniAdaptor::t('tax', 'From Zip') . '  ' . $zone['from_zip'] . '  ' . UsniAdaptor::t('application', 'To Zip') . '  ' . $zone['to_zip'];
        }
        return UsniAdaptor::t('application',  '(not set)');
    }
}
