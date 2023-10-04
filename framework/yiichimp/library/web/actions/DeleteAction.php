<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\web\actions;

use usni\UsniAdaptor;
use yii\web\ForbiddenHttpException;
use usni\library\db\TranslatableActiveRecord;
use usni\library\utils\CacheUtil;
/**
 * DeleteAction class file. This would handle deleting a model.
 *
 * @package usni\library\web\actions
 */
class DeleteAction extends Action
{
    /**
     * Url where browser would redirect after delete
     * @var string 
     */
    public $redirectUrl;
    
    /**
     * Permission which has to be checked before delete to verify that current user can delete the model
     * @var string 
     */
    public $permission;
    
    /**
     * Runs the action
     * @param int $id
     * @return string
     */
    public function run($id)
    {
        $isPermissible      = true;
        $user               = UsniAdaptor::app()->user->getIdentity();
        $model              = $this->findModel($id);
        if($this->permission == null)
        {
            $this->permission   = strtolower($this->getModelBaseName()) . '.deleteother';
        }
        if($model->hasAttribute('created_by') && ($user->id != $model->created_by))
        {
            $isPermissible      = UsniAdaptor::app()->user->can($this->permission);
        }
        if(!$isPermissible)
        {
            throw new ForbiddenHttpException(\Yii::t('yii','You are not authorized to perform this action.'));
        }
        else
        {
            try
            {
                if($model instanceof TranslatableActiveRecord)
                {
                    $model->language = UsniAdaptor::app()->languageManager->selectedLanguage;
                }
                $model->delete();
                //Clear cache after model delete.
                CacheUtil::clearCache();
            }
            catch(\yii\db\Exception $e)
            {
                $message = UsniAdaptor::t('applicationflash', 'Delete failed due to error: <strong>{error}</strong>', ['error' => $e->getMessage()]);
                UsniAdaptor::app()->getSession()->setFlash('error', $message);
            }
            return $this->controller->redirect([$this->redirectUrl]);
        }
    }
}