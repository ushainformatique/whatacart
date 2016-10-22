<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\localization\modules\weightclass\controllers;

use common\modules\localization\modules\weightclass\models\WeightClass;
use common\modules\localization\controllers\LocalizationController;
use usni\UsniAdaptor;
use common\modules\localization\modules\weightclass\utils\WeightClassUtil;
/**
 * DefaultController class file
 * 
 * @package common\modules\localization\modules\weightclass\controllers
 */
class DefaultController extends LocalizationController
{
    use \usni\library\traits\EditViewTranslationTrait;
    
    /**
     * @inheritdoc
     */
    protected function resolveModelClassName()
    {
        return WeightClass::className();
    }
    
    /**
     * @inheritdoc
     */
    public function pageTitles()
    {
        return [
                    'create'         => UsniAdaptor::t('application','Create') . ' ' . WeightClass::getLabel(1),
                    'update'         => UsniAdaptor::t('application','Update') . ' ' . WeightClass::getLabel(1),
                    'view'           => UsniAdaptor::t('application','View') . ' ' . WeightClass::getLabel(1),
                    'manage'         => UsniAdaptor::t('application','Manage') . ' ' . WeightClass::getLabel(2)
               ];
    }
    
    /**
     * @inheritdoc
     */
    protected function deleteModel($model)
    {
        $isAllowedToDelete = WeightClassUtil::checkIfAllowedToDelete($model);
        if(!$isAllowedToDelete)
        {
            $message = UsniAdaptor::t('applicationflash', 'The model could not be deleted.');
            UsniAdaptor::app()->getSession()->setFlash('deleteFailed', $message);
            return false;
        }
        return parent::deleteModel($model);
    }
}