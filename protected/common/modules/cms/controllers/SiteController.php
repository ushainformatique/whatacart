<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace common\modules\cms\controllers;

use frontend\controllers\BaseController;
use usni\UsniAdaptor;
use common\modules\cms\dao\PageDAO;
/**
 * SiteController class file
 *
 * @package common\modules\cms\controllers
 */
class SiteController extends BaseController
{
    /**
     * Renders page
     * 
     * @param string $alias
     * @return string
     */
    public function actionPage($alias)
    {
        $page     = PageDAO::getByAlias($alias, UsniAdaptor::app()->languageManager->selectedLanguage);
        if($page['metakeywords'] != null)
        {
            $this->getView()->registerMetaTag([
                'name' => 'keywords',
                'content' => $page['metakeywords']
            ]);
        }
        if($page['metadescription'] != null)
        {
            $this->getView()->registerMetaTag([
                'name' => 'description',
                'content' => $page['metadescription']
            ]);
        }
        return $this->render('/front/page', ['page' => $page]);
    }
}
