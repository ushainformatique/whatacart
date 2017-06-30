<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace common\modules\localization\modules\city\business;

use common\modules\localization\modules\city\dao\CityDAO;
use common\modules\localization\modules\country\models\CountryTranslated;
use yii\base\InvalidParamException;
use common\modules\localization\modules\country\behaviors\CountryBehavior;
/**
 * Manager class file.
 *
 * @package common\modules\localization\modules\city\business
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
        $countryData = $this->getCountryDropdownData();
        $formDTO->setCountryDropDown($countryData);
    }
    
    /**
     * @inheritdoc
     */
    public function beforeModelSave($model)
    {
        if(parent::beforeModelSave($model))
        {
            if(isset($_POST['City']['country_id']) && is_array($_POST['City']['country_id']))
            {
                $model->country_id = $_POST['City']['country_id'][0];
            }
            return true;
        }
        return false;
    }
    
    /**
     * inheritdoc
     */
    public function processList($gridViewDTO) 
    {
        parent::processList($gridViewDTO);
        $countryData = $this->getCountryDropdownData();
        $gridViewDTO->setCountryDropdownData($countryData);
    }
    
    /**
     * inheritdoc
     */
    public function getBrowseModels($modelClass)
    {
        return CityDAO::getAll($this->language);
    }
    
    /**
     * inheritdoc
     */
    public function loadModel($modelClass, $id)
    {
        $model      = CityDAO::getById($id, $this->language);
        if ($model === null)
        {
            throw new InvalidParamException("Object not found: $id");
        }
        $country = CountryTranslated::find()->where('owner_id = :id AND language = :lang', [':id' => $model['country_id'], 
                                                                                      ':lang' => $this->language])->asArray()->one();
        $model['country'] = $country['name'];
        return $model;
    }
}