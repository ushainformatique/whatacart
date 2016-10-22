<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace taxes\controllers;

use taxes\controllers\BaseController;
use taxes\models\Zone;
use usni\UsniAdaptor;
use taxes\utils\TaxUtil;
/**
 * ZoneController class file
 * @package taxes\controllers
 */
class ZoneController extends BaseController
{
    use \usni\library\traits\EditViewTranslationTrait;
    
    /**
     * @inheritdoc
     */
    protected function resolveModelClassName()
    {
        return Zone::className();
    }

    /**
     * @inheritdoc
     */
    protected function beforeModelSave($zone)
    {
        return true;
    }
    
    /**
     * @inheritdoc
     */
    public function pageTitles()
    {
        return [
                    'create'         => UsniAdaptor::t('application','Create') . ' ' . Zone::getLabel(1),
                    'update'         => UsniAdaptor::t('application','Update') . ' ' . Zone::getLabel(1),
                    'view'           => UsniAdaptor::t('application','View') . ' ' . Zone::getLabel(1),
                    'manage'         => UsniAdaptor::t('application','Manage') . ' ' . Zone::getLabel(2)
               ];
    }
    
    /**
     * @inheritdoc
     */
    protected function deleteModel($model)
    {
        $isAllowedToDelete = TaxUtil::checkIfZoneAllowedToDelete($model);
        if(!$isAllowedToDelete)
        {
            $message = UsniAdaptor::t('taxflash', 'Delete failed as this zone is associated with tax rate.');
            UsniAdaptor::app()->getSession()->setFlash('deleteFailed', $message);
            return false;
        }
        return parent::deleteModel($model);
    }
}
?>