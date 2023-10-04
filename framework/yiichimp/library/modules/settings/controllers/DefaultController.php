<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\modules\settings\controllers;

use usni\UsniAdaptor;
use usni\library\utils\ArrayUtil;
use usni\library\utils\FlashUtil;
use yii\filters\AccessControl;
use usni\library\modules\settings\business\Manager;
use usni\library\modules\settings\dto\FormDTO;
use usni\library\utils\FileUtil;
/**
 * DefaultController class file.
 * 
 * @package usni\library\modules\settings\controllers
 */
class DefaultController extends \usni\library\web\Controller
{
    /**
     * inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['site', 'delete-image'],
                        'roles' => ['settings.site'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['email'],
                        'roles' => ['settings.email'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['database'],
                        'roles' => ['settings.database'],
                    ],
                ],
            ],
        ];
    }
    
    /**
     * Email settings.
     * @return void
     */
    public function actionEmail()
    {
        $formDTO    = new FormDTO();
        $postData   = ArrayUtil::getValue($_POST, 'EmailSettingsForm');
        $formDTO->setPostData($postData);
        $manager = new Manager(['userId' => UsniAdaptor::app()->user->getIdentity()->getId()]);
        $manager->processEmail($formDTO);
        if($formDTO->getTestEmailSent() == true)
        {
            FlashUtil::setMessage('testEmailSent', UsniAdaptor::t('settingsflash', 'Test email is sent successfully.'));
        }
        if($formDTO->getEmptyTestEmailAddress() == true)
        {
            FlashUtil::setMessage('testEmailNotProvided', UsniAdaptor::t('settingsflash', 'Test email address is not provided.'));
        }
        if($formDTO->getIsTransactionSuccess() == true)
        {
            FlashUtil::setMessage('emailSettingsSaved', UsniAdaptor::t('settingsflash', 'Email settings are saved successfully.'));
            return $this->refresh();
        }
        else
        {
            return $this->render('/emailsettings', ['formDTO' => $formDTO]);
        }
    }

    /**
     * Site settings
     * @return void
     */
    public function actionSite()
    {
        $formDTO    = new FormDTO();
        $postData   = ArrayUtil::getValue($_POST, 'SiteSettingsForm');
        $formDTO->setPostData($postData);
        $manager    = new Manager();
        $manager->processSite($formDTO);
        if($formDTO->getIsTransactionSuccess() == true)
        {
            FlashUtil::setMessage('success', UsniAdaptor::t('settingsflash', 'Site settings are saved successfully.'));
            return $this->refresh();
        }
        else
        {
            return $this->render('/sitesettings', ['formDTO' => $formDTO]);
        }
    }
    
    /**
     * Database settings.
     * @return void
     */
    public function actionDatabase()
    {
        $formDTO    = new FormDTO();
        $postData   = ArrayUtil::getValue($_POST, 'DatabaseSettingsForm');
        $formDTO->setPostData($postData);
        $manager    = new Manager(['userId' => UsniAdaptor::app()->user->getIdentity()->getId()]);
        $manager->processDatabaseSettings($formDTO);
        if($formDTO->getIsTransactionSuccess() == true)
        {
            FlashUtil::setMessage('success', UsniAdaptor::t('settingsflash', 'Database settings are saved successfully.'));
            return $this->refresh();
        }
        else
        {
            return $this->render('/databasesettings', ['formDTO' => $formDTO]);
        }
    }
    
    /**
     * Delete image.
     */
    public function actionDeleteImage()
    {
        if(UsniAdaptor::app()->request->isAjax)
        {
            $fileName   = UsniAdaptor::app()->configManager->getValue('application', 'logo');
            $path       = UsniAdaptor::app()->assetManager->imageUploadPath;
            $thumbPath  = UsniAdaptor::app()->assetManager->thumbUploadPath;
            $filePath   = FileUtil::normalizePath($path . DS . $fileName);
            if(file_exists($filePath) && is_file($filePath))
            {
                unlink($filePath);
                $thumbFilePath   = FileUtil::normalizePath($thumbPath . DS . 150 . '_' . 150 . '_' . $fileName);
                if(file_exists($thumbFilePath) && is_file($thumbFilePath))
                {
                    unlink($thumbFilePath);
                }
                $table = UsniAdaptor::tablePrefix() . 'configuration';
                $sql   = "UPDATE $table tc SET value = :value WHERE tc.key = :key";
                UsniAdaptor::app()->db->createCommand($sql, [':key' => 'logo', ':value' => null])->execute();
            }
        }
    }
}