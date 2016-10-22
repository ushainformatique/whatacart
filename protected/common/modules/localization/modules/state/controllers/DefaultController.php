<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\localization\modules\state\controllers;

use common\modules\localization\modules\state\models\State;
use common\modules\localization\controllers\LocalizationController;
use common\modules\localization\modules\state\utils\StateUtil;
use usni\UsniAdaptor;
use usni\library\utils\ArrayUtil;
/**
 * DefaultController class file
 * 
 * @package common\modules\localization\modules\state\controllers
 */
class DefaultController extends LocalizationController
{
    use \usni\library\traits\EditViewTranslationTrait;
    
    /**
     * @inheritdoc
     */
    protected function resolveModelClassName()
    {
        return State::className();
    }

   /**
     * @inheritdoc
     */
    protected function beforeModelSave($state)
    {
        if(isset($_POST['State']['country_id']) && is_array($_POST['State']['country_id']))
        {
            $state->country_id = $_POST['State']['country_id'][0];
            $state->save();
        }
        return true;
    }
    
    /**
     * Get states by country
     * @param type $countryId
     */
    public function actionGetStatesByCountry($countryId)
    {
        $str = null;
        $dropdownData = StateUtil::getStatesOptionByCountryId($countryId);
        foreach($dropdownData as $id => $value)
        {
            $str .= "<option value='{$id}'>{$value}</option>";
        }
        return $str;
    }
    
    /**
     * @inheritdoc
     */
    public function pageTitles()
    {
        return [
                    'create'         => UsniAdaptor::t('application','Create') . ' ' . State::getLabel(1),
                    'update'         => UsniAdaptor::t('application','Update') . ' ' . State::getLabel(1),
                    'view'           => UsniAdaptor::t('application','View') . ' ' . State::getLabel(1),
                    'manage'         => UsniAdaptor::t('application','Manage') . ' ' . State::getLabel(2)
               ];
    }
    
    /**
     * @inheritdoc
     */
    protected static function getNonPermissibleActions()
    {
        $actions = parent::getNonPermissibleActions();
        return ArrayUtil::merge($actions, ['get-states-by-country']);
    }
    
    /**
     * @inheritdoc
     */
    protected function deleteModel($model)
    {
        $isAllowedToDelete = StateUtil::checkIfStateAllowedToDelete($model);
        if(!$isAllowedToDelete)
        {
            $message = UsniAdaptor::t('localizationflash', 'Delete failed as this state is associated with Zone.');
            UsniAdaptor::app()->getSession()->setFlash('deleteFailed', $message);
            return false;
        }
        return parent::deleteModel($model);
    }
}