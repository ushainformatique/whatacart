<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace common\modules\localization\modules\country\business;

use common\modules\localization\modules\country\dao\CountryDAO;
use yii\base\InvalidParamException;
use usni\UsniAdaptor;
/**
 * Manager class file.
 *
 * @package common\modules\localization\modules\country\business
 */
class Manager extends \usni\library\business\Manager
{    
    /**
     * inheritdoc
     */
    public function getBrowseModels($modelClass)
    {
        return CountryDAO::getAll($this->language);
    }
    
    /**
     * inheritdoc
     */
    public function loadModel($modelClass, $id)
    {
        $model      = CountryDAO::getById($id, $this->language);
        if ($model === null)
        {
            throw new InvalidParamException("Object not found: $id");
        }
        $model['postcode_required'] = $this->getPostcodeRequiredLabel($model);
        return $model;
    }
    
    /**
     * Gets label for the status.
     * 
     * @param string $model Model.
     * @return string
     */
    public function getPostcodeRequiredLabel($model)
    {
        if ($model['postcode_required'] == 0)
        {
            return UsniAdaptor::t('application', 'No');
        }
        elseif ($model['postcode_required'] == 1)
        {
            return UsniAdaptor::t('application', 'Yes');
        }
    }
}