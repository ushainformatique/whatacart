<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace frontend\modules\site\views;

use usni\UsniAdaptor;
use frontend\views\FrontPageView;
use frontend\utils\FrontUtil;
/**
 * ContactPageView class file
 * @package frontend\modules\site\views
 */
class ContactPageView extends FrontPageView
{
    /**
     * Model associated with the form
     * @var Model 
     */
    public $model;
    /**
     * @inheritdoc
     */
    protected function renderInnerContent()
    {
        $themeName      = FrontUtil::getThemeName();
        $file           = UsniAdaptor::getAlias('@themes/' . $themeName . '/views/site/_contactus') . '.php';
        $view           = UsniAdaptor::app()->getModule('site')->viewHelper->getInstance('contactFormView', ['model' => $this->model]);
        return $this->getView()->renderPhpFile($file, ['form' => $view->render()]);
    }
}