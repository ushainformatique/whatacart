<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace taxes\controllers;

use taxes\controllers\BaseController;
use taxes\models\TaxRate;
use usni\UsniAdaptor;
use taxes\utils\TaxUtil;
/**
 * TaxRateController class file
 * @package taxes\controllers
 */
class TaxRateController extends BaseController
{
    use \usni\library\traits\EditViewTranslationTrait;
    
    /**
     * @inheritdoc
     */
    protected function resolveModelClassName()
    {
        return TaxRate::className();
    }
    
    /**
     * @inheritdoc
     */
    public function pageTitles()
    {
        return [
                    'create'         => UsniAdaptor::t('application','Create') . ' ' . TaxRate::getLabel(1),
                    'update'         => UsniAdaptor::t('application','Update') . ' ' . TaxRate::getLabel(1),
                    'view'           => UsniAdaptor::t('application','View') . ' ' . TaxRate::getLabel(1),
                    'manage'         => UsniAdaptor::t('application','Manage') . ' ' . TaxRate::getLabel(2)
               ];
    }
    
    /**
     * @inheritdoc
     */
    protected function deleteModel($model)
    {
        $isAllowedToDelete = TaxUtil::checkIfTaxRateAllowedToDelete($model);
        if(!$isAllowedToDelete)
        {
            $message = UsniAdaptor::t('taxflash', 'Delete failed as this tax rate is associated with tax rule.');
            UsniAdaptor::app()->getSession()->setFlash('deleteFailed', $message);
            return false;
        }
        return parent::deleteModel($model);
    }
}
?>