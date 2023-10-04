<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\modules\settings\business;

use usni\library\modules\settings\dto\FormDTO;
use usni\library\modules\settings\models\SiteSettingsForm;
use usni\UsniAdaptor;
use usni\library\managers\UploadInstanceManager;
use yii\web\UploadedFile;
use usni\library\utils\FileUploadUtil;
use usni\library\modules\settings\models\EmailSettingsForm;
use usni\library\utils\ArrayUtil;
use usni\library\modules\settings\models\DatabaseSettingsForm;
/**
 * Manager class file
 * 
 * @package usni\library\modules\settings\business
 */
class Manager extends \usni\library\business\Manager
{
    /**
     * Process site setting.
     * @param FormDTO $formDTO
     */
    public function processSite($formDTO)
    {
        $postData   = $formDTO->getPostData();
        $model      = new SiteSettingsForm();
        if(isset($postData))
        {
            $model->attributes = $postData;
            $config = [
                                'model'             => $model,
                                'attribute'         => 'logo',
                                'uploadInstanceAttribute' => 'uploadInstance',
                                'type'              => 'image',
                                'savedAttribute'    => 'savedLogo',
                                'fileMissingError'  => UsniAdaptor::t('application', 'Please upload image'),
                          ];
            $uploadInstanceManager  = new UploadInstanceManager($config);
            $result                 = $uploadInstanceManager->processUploadInstance();
            if($model->validate(null, false) && $result)
            {
                UsniAdaptor::app()->configManager->processInsertOrUpdateConfiguration($model, 'application', ['savedLogo', 'uploadInstance']);
                if(empty($model->errors))
                {
                    $model->savedLogo   = UsniAdaptor::app()->configManager->getValue('application', 'logo');
                    if($model->logo != null)
                    {
                        $config = [
                                        'model'             => $model, 
                                        'attribute'         => 'logo', 
                                        'uploadInstance'    => $model->uploadInstance, 
                                        'savedFile'         => $model->savedLogo
                                  ];
                        FileUploadUtil::save('image', $config);
                    }
                    $formDTO->setIsTransactionSuccess(true);
                }
            }
        }
        else
        {
            $model->attributes = UsniAdaptor::app()->configManager->getModuleConfiguration('application');
        }
        $formDTO->setModel($model);
    }
    
    /**
     * Process email setting.
     * @param FormDTO $formDTO
     */
    public function processEmail($formDTO)
    {
        $postData   = $formDTO->getPostData();
        $model      = new EmailSettingsForm();
        if(isset($postData))
        {
            $testEmailAddress = null;
            $sendTestEmail    = null;
            $model->attributes = $postData;
            if($model->validate())
            {
                $attributes         = $model->getAttributes();
                $testEmailAddress   = $attributes['testEmailAddress'];
                $sendTestEmail      = $attributes['sendTestMail'];
                unset($attributes['testEmailAddress']);
                unset($attributes['sendTestMail']);
                UsniAdaptor::app()->configManager->insertOrUpdateConfiguration('settings', 'emailSettings', serialize($attributes));
                $formDTO->setIsTransactionSuccess(true);
                if((bool)$model->sendTestMail === true)
                {
                    if($model->testEmailAddress != null)
                    {
                        if($model->testMode)
                        {
                            UsniAdaptor::app()->mailer->useFileTransport = true;
                        }
                        $model->sendTestMail();
                        $formDTO->setTestEmailSent(true);
                    }
                    else
                    {
                        $formDTO->setEmptyTestEmailAddress(true);
                    }
                }
            }
        }
        else
        {
            $settingsConf   = UsniAdaptor::app()->configManager->getModuleConfiguration('settings');
            $emailSettings  = ArrayUtil::getValue($settingsConf, 'emailSettings' );
            if($emailSettings != null)
            {
                $emailSettings     = unserialize($emailSettings);
                $model->attributes = $emailSettings;
            }
        }
        $formDTO->setModel($model);
    }
    
    /**
     * Process database settings.
     * @param FormDTO $formDTO
     */
    public function processDatabaseSettings($formDTO)
    {
        $model      = new DatabaseSettingsForm();
        $postData   = $formDTO->getPostData();
        if(isset($postData))
        {
            $model->attributes = $postData;
            if($model->validate())
            {
                UsniAdaptor::app()->configManager->processInsertOrUpdateConfiguration($model, 'application');
                if(empty($model->errors))
                {
                    $formDTO->setIsTransactionSuccess(true);
                }
            }
        }
        else
        {
            $model->attributes = UsniAdaptor::app()->configManager->getModuleConfiguration('application');
        }
        $formDTO->setModel($model);
    }
}
