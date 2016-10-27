<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\localization\modules\currency\controllers;

use common\modules\localization\modules\currency\models\Currency;
use common\modules\localization\controllers\LocalizationController;
use usni\UsniAdaptor;
use usni\library\utils\CacheUtil;
use common\modules\order\utils\OrderUtil;
/**
 * DefaultController class file
 * @package common\modules\localization\modules\currency\controllers
 */
class DefaultController extends LocalizationController
{
    use \usni\library\traits\EditViewTranslationTrait;
    
    /**
     * @inheritdoc
     */
    protected function resolveModelClassName()
    {
        return Currency::className();
    }
    
    /**
     * @inheritdoc
     */
    public function pageTitles()
    {
        return [
                    'create'         => UsniAdaptor::t('application','Create') . ' ' . Currency::getLabel(1),
                    'update'         => UsniAdaptor::t('application','Update') . ' ' . Currency::getLabel(1),
                    'view'           => UsniAdaptor::t('application','View') . ' ' . Currency::getLabel(1),
                    'manage'         => UsniAdaptor::t('application','Manage') . ' ' . Currency::getLabel(2)
               ];
    }
    
    /**
     * @inheritdoc
     */
    public function afterModelSave($model)
    {
        CacheUtil::delete('allowedCurrenciesList');
        return true;
    }
    
    /**
     * @inheritdoc
     */
    protected function deleteModel($model)
    {
        $orders = OrderUtil::getOrdersByAttribute('currency_code', $model['code']);
        if($model['value'] == 1.00 && !empty($orders))
        {
            $message = UsniAdaptor::t('applicationflash', 'The model could not be deleted.');
            UsniAdaptor::app()->getSession()->setFlash('deleteFailed', $message);
            return false;
        }
        return parent::deleteModel($model);
    }
}
?>