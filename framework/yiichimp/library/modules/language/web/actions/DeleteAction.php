<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\modules\language\web\actions;

use usni\UsniAdaptor;
/**
 * DeleteAction class file. This would handle deleting a model.
 *
 * @package usni\library\modules\language\web\actions
 */
class DeleteAction extends \usni\library\web\actions\DeleteAction
{
    /**
     * inheritdoc
     */
    public function run($id)
    {
        //Before delete selected language make default language selected.
        $selectedLanguage = UsniAdaptor::app()->languageManager->selectedLanguage;
        $model            = $this->findModel($id);
        if($model->code === $selectedLanguage)
        {
            UsniAdaptor::app()->cookieManager->setLanguageCookie('en-US');
        }
        parent::run($id);
    }
}