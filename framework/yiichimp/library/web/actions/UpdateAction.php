<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\web\actions;

use usni\UsniAdaptor;
use yii\web\ForbiddenHttpException;
/**
 * UpdateAction class file
 *
 * @package usni\library\web\actions
 */
class UpdateAction extends EditAction
{
    /**
     * inheritdoc
     */
    public $scenario = 'update';
    
    /**
     * Runs the action
     * @param int $id
     * @return string
     */
    public function run($id)
    {
        $isPermissible      = true;
        $user               = UsniAdaptor::app()->user->getIdentity();
        /* @var $model ActiveRecord */
        $model              = $this->findModel($id);
        //Derive manager and call the function
        $manager            = $this->getManagerInstance();
        //This is applicable in both scenario.
        //1) If permission prefix would be based on model basename 
        //2) If permission prefix would not be based on model basename 
        $permissionPrefix   = $manager->getPermissionPrefix(UsniAdaptor::getObjectClassName($model));
        if($model->hasAttribute('created_by'))
        {
            if($user->id != $model->created_by)
            {
                $isPermissible      = UsniAdaptor::app()->user->can($permissionPrefix . '.updateother');
            }
        }
        if(!$isPermissible)
        {
            throw new ForbiddenHttpException(\Yii::t('yii','You are not authorized to perform this action.'));
        }
        else
        {
            $model->scenario    = $this->scenario;
            $postData           = UsniAdaptor::app()->request->post();
            $formDTO            = new $this->formDTOClass();
            $formDTO->setModel($model);
            $formDTO->setPostData($postData);
            $formDTO->setScenario('update');
            
            $manager->processEdit($formDTO);
            if($formDTO->getIsTransactionSuccess())
            {
                $message = UsniAdaptor::t('applicationflash', 'Record has been updated successfully.');
                UsniAdaptor::app()->getSession()->setFlash('success', $message);
                return $this->controller->refresh();
            }
            else
            {
                if($this->viewFile == null)
                {
                    return $this->controller->render('update', ['formDTO' => $formDTO]);
                }
                return $this->controller->render($this->viewFile, ['formDTO' => $formDTO]);
            }
        }
    }
}