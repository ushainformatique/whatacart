<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\localization\modules\orderstatus\controllers;

use common\modules\localization\modules\orderstatus\models\OrderStatus;
use common\modules\localization\controllers\LocalizationController;
use usni\UsniAdaptor;
use common\modules\localization\modules\orderstatus\utils\OrderStatusUtil;
/**
 * DefaultController class file
 * 
 * @package common\modules\orderstatus\controllers
 */
class DefaultController extends LocalizationController
{
    use \usni\library\traits\EditViewTranslationTrait;
    /**
     * @inheritdoc
     */
    protected function resolveModelClassName()
    {
        return OrderStatus::className();
    }
    
    /**
     * @inheritdoc
     */
    public function pageTitles()
    {
        return [
                    'create'         => UsniAdaptor::t('application','Create') . ' ' . OrderStatus::getLabel(1),
                    'update'         => UsniAdaptor::t('application','Update') . ' ' . OrderStatus::getLabel(1),
                    'view'           => UsniAdaptor::t('application','View') . ' ' . OrderStatus::getLabel(1),
                    'manage'         => UsniAdaptor::t('application','Manage') . ' ' . OrderStatus::getLabel(1)
               ];
    }
    
    /**
     * @inheritdoc
     */
    protected function deleteModel($model)
    {
        $isAllowedToDelete = OrderStatusUtil::checkIfAllowedToDelete($model);
        if(!$isAllowedToDelete)
        {
            $message = UsniAdaptor::t('orderstatusflash', 'The model could not be deleted as orders are associated to it.');
            UsniAdaptor::app()->getSession()->setFlash('deleteFailed', $message);
            return false;
        }
        return parent::deleteModel($model);
    }
}