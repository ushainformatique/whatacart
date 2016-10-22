<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\localization\modules\country\controllers;

use common\modules\localization\modules\country\models\Country;
use common\modules\localization\controllers\LocalizationController;
use usni\UsniAdaptor;
/**
 * DefaultController class file
 * @package common\modules\localization\modules\country\controllers
 */
class DefaultController extends LocalizationController
{
    use \usni\library\traits\EditViewTranslationTrait;
    
    /**
     * @inheritdoc
     */
    protected function resolveModelClassName()
    {
        return Country::className();
    }
    
    /**
     * @inheritdoc
     */
    public function pageTitles()
    {
        return [
                    'create'         => UsniAdaptor::t('application','Create') . ' ' . Country::getLabel(1),
                    'update'         => UsniAdaptor::t('application','Update') . ' ' . Country::getLabel(1),
                    'view'           => UsniAdaptor::t('application','View') . ' ' . Country::getLabel(1),
                    'manage'         => UsniAdaptor::t('application','Manage') . ' ' . Country::getLabel(2)
               ];
    }
}
?>