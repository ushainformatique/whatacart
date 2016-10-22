<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\localization\modules\city\controllers;

use common\modules\localization\modules\city\models\City;
use common\modules\localization\controllers\LocalizationController;
use usni\UsniAdaptor;
/**
 * DefaultController class file
 * @package common\modules\localization\modules\city\controllers
 */
class DefaultController extends LocalizationController
{
    use \usni\library\traits\EditViewTranslationTrait;
    
    /**
     * @inheritdoc
     */
    protected function resolveModelClassName()
    {
        return City::className();
    }

    /**
     * @inheritdoc
     */
    protected function beforeModelSave($city)
    {
        if(isset($_POST['City']['country_id']) && is_array($_POST['City']['country_id']))
        {
            $city->country_id = $_POST['City']['country_id'][0];
            $city->save();
        }
        return true;
    }
    
    /**
     * @inheritdoc
     */
    public function pageTitles()
    {
        return [
                    'create'         => UsniAdaptor::t('application','Create') . ' ' . City::getLabel(1),
                    'update'         => UsniAdaptor::t('application','Update') . ' ' . City::getLabel(1),
                    'view'           => UsniAdaptor::t('application','View') . ' ' . City::getLabel(1),
                    'manage'         => UsniAdaptor::t('application','Manage') . ' ' . City::getLabel(2)
               ];
    }
}
?>