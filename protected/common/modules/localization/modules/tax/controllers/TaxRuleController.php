<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace taxes\controllers;

use taxes\controllers\BaseController;
use taxes\models\TaxRule;
use usni\UsniAdaptor;
/**
 * TaxRuleController class file
 * @package taxes\controllers
 */
class TaxRuleController extends BaseController
{
    use \usni\library\traits\EditViewTranslationTrait;
    
    /**
     * @inheritdoc
     */
    protected function resolveModelClassName()
    {
        return TaxRule::className();
    }
    
    /**
     * @inheritdoc
     */
    public function pageTitles()
    {
        return [
                    'create'         => UsniAdaptor::t('application','Create') . ' ' . TaxRule::getLabel(1),
                    'update'         => UsniAdaptor::t('application','Update') . ' ' . TaxRule::getLabel(1),
                    'view'           => UsniAdaptor::t('application','View') . ' ' . TaxRule::getLabel(1),
                    'manage'         => UsniAdaptor::t('application','Manage') . ' ' . TaxRule::getLabel(2)
               ];
    }
}
?>