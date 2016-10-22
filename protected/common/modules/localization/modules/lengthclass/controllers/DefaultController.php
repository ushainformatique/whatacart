<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\localization\modules\lengthclass\controllers;

use common\modules\localization\modules\lengthclass\models\LengthClass;
use common\modules\localization\controllers\LocalizationController;
use usni\UsniAdaptor;
use common\modules\localization\modules\lengthclass\utils\LengthClassUtil;
/**
 * DefaultController class file
 * 
 * @package common\modules\localization\modules\lengthclass\controllers
 */
class DefaultController extends LocalizationController
{
    use \usni\library\traits\EditViewTranslationTrait;
    
    /**
     * @inheritdoc
     */
    protected function resolveModelClassName()
    {
        return LengthClass::className();
    }
    
    /**
     * @inheritdoc
     */
    public function pageTitles()
    {
        return [
                    'create'         => UsniAdaptor::t('application','Create') . ' ' . LengthClass::getLabel(1),
                    'update'         => UsniAdaptor::t('application','Update') . ' ' . LengthClass::getLabel(1),
                    'view'           => UsniAdaptor::t('application','View') . ' ' . LengthClass::getLabel(1),
                    'manage'         => UsniAdaptor::t('application','Manage') . ' ' . LengthClass::getLabel(2)
               ];
    }
    
    /**
     * @inheritdoc
     */
    protected function deleteModel($model)
    {
        $isAllowedToDelete = LengthClassUtil::checkIfAllowedToDelete($model);
        if(!$isAllowedToDelete)
        {
            $message = UsniAdaptor::t('applicationflash', 'The model could not be deleted.');
            UsniAdaptor::app()->getSession()->setFlash('deleteFailed', $message);
            return false;
        }
        return parent::deleteModel($model);
    }
}