<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\localization\modules\stockstatus\controllers;

use common\modules\localization\modules\stockstatus\models\StockStatus;
use common\modules\localization\controllers\LocalizationController;
use usni\UsniAdaptor;
use common\modules\localization\modules\stockstatus\utils\StockStatusUtil;
/**
 * DefaultController class file
 * 
 * @package common\modules\localization\modules\stockstatus\controllers
 */
class DefaultController extends LocalizationController
{
    use \usni\library\traits\EditViewTranslationTrait;
    
    /**
     * @inheritdoc
     */
    protected function resolveModelClassName()
    {
        return StockStatus::className();
    }
    
    /**
     * @inheritdoc
     */
    public function pageTitles()
    {
        return [
                    'create'         => UsniAdaptor::t('application','Create') . ' ' . StockStatus::getLabel(1),
                    'update'         => UsniAdaptor::t('application','Update') . ' ' . StockStatus::getLabel(1),
                    'view'           => UsniAdaptor::t('application','View') . ' ' . StockStatus::getLabel(1),
                    'manage'         => UsniAdaptor::t('application','Manage') . ' ' . StockStatus::getLabel(1)
               ];
    }
    
    /**
     * @inheritdoc
     */
    protected function deleteModel($model)
    {
        $isAllowedToDelete = StockStatusUtil::checkIfAllowedToDelete($model);
        if(!$isAllowedToDelete)
        {
            $message = UsniAdaptor::t('stockstatusflash', 'The model could not be deleted as products are associated to it.');
            UsniAdaptor::app()->getSession()->setFlash('deleteFailed', $message);
            return false;
        }
        return parent::deleteModel($model);
    }
}