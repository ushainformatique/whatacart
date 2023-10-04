<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\web\actions;

use usni\library\utils\ArrayUtil;
use usni\library\modules\users\dto\UserFormDTO;
use usni\library\modules\users\utils\UserUtil;
use usni\UsniAdaptor;
use usni\library\utils\FlashUtil;
use yii\web\ForbiddenHttpException;
/**
 * ChangePasswordAction class file. This is a standalone action for change password functionality.
 *
 * @package usni\library\web\actions
 */
class ChangePasswordAction extends Action
{
    /**
     * Runs the action
     * @param int $id
     * @return string
     */
    public function run($id)
    {
        $postData   = ArrayUtil::getValue($_POST, ['ChangePasswordForm']);
        $formDTO    = new UserFormDTO();
        $formDTO->setPostData($postData);
        $formDTO->setId($id);
        $formDTO->setModelClassName($this->modelClass);
        $manager    = $this->getManagerInstance();
        $manager->processChangePassword($formDTO);
        UsniAdaptor::app()->getSession()->setFlash('warning', UserUtil::getPasswordInstructions());
        if($formDTO->getIsTransactionSuccess() === true)
        {
            FlashUtil::setMessage('success', UsniAdaptor::t('userflash', 'Password has been changed successfully.'));
            return $this->controller->refresh();
        }
        elseif($formDTO->getIsTransactionSuccess() === false)
        {
            throw new ForbiddenHttpException(\Yii::t('yii','You are not authorized to perform this action.'));
        }
        elseif($this->viewFile != null)
        {
            return $this->controller->render($this->viewFile, ['formDTO' => $formDTO]);
        }
        else
        {
            return $this->controller->render('changepassword', ['formDTO' => $formDTO]);
        } 
    }
}