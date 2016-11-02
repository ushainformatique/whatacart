<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace common\modules\dataCategories\controllers;

use usni\library\components\UiAdminController;
use common\modules\dataCategories\models\DataCategory;
use usni\UsniAdaptor;
use common\modules\dataCategories\utils\DataCategoryUtil;
/**
 * DefaultController class file
 * 
 * @package common\modules\dataCategories\controllers
 */
class DefaultController extends UiAdminController
{
    use \usni\library\traits\EditViewTranslationTrait;
    
    /**
     * @inheritdoc
     */
    protected function resolveModelClassName()
    {
        return DataCategory::className();
    }
    
    /**
     * @inheritdoc
     */
    protected function deleteModel($model)
    {
        $isAllowedToDelete = DataCategoryUtil::checkIfAllowedToDelete($model);
        if(!$isAllowedToDelete)
        {
            $message = UsniAdaptor::t('datacategoryflash', 'Delete failed as either this is root category or stores are associated to data category');
            UsniAdaptor::app()->getSession()->setFlash('deleteFailed', $message);
            return false;
        }
        return parent::deleteModel($model);
    }
    
    /**
     * @inheritdoc
     */
    public function actionUpdate($id)
    {
        $model = DataCategory::findOne($id);
        if($model['id'] == DataCategory::ROOT_CATEGORY_ID)
        {
            throw new \yii\web\ForbiddenHttpException(\Yii::t('yii','Root category could not be updated.'));
        }
        return parent::actionUpdate($id);
    }
    
    /**
     * @inheritdoc
     */
    public function pageTitles()
    {
        return [
                    'create'         => UsniAdaptor::t('application','Create') . ' ' . DataCategory::getLabel(1),
                    'update'         => UsniAdaptor::t('application','Update') . ' ' . DataCategory::getLabel(1),
                    'view'           => UsniAdaptor::t('application','View') . ' ' . DataCategory::getLabel(1),
                    'manage'         => UsniAdaptor::t('application','Manage') . ' ' . DataCategory::getLabel(1)
               ];
    }
}