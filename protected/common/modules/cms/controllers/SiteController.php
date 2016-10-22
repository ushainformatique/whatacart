<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace common\modules\cms\controllers;

use frontend\controllers\BaseController;
use frontend\utils\FrontUtil;
use frontend\components\Breadcrumb;
use common\modules\cms\utils\PageUtil;
use usni\UsniAdaptor;
/**
 * SiteController class file
 *
 * @package common\modules\cms\controllers
 */
class SiteController extends BaseController
{
    /**
     * Page which is called
     * @var array 
     */
    public $page;
    
    /**
     * Renders page
     * 
     * @param string $alias
     * @return string
     */
    public function actionPage($alias)
    {
        $this->page     = PageUtil::getPageByAlias($alias);
        $breadcrumbView = new Breadcrumb(['page' => $this->page['name']]);
        $this->getView()->params['breadcrumbs'] = $breadcrumbView->getBreadcrumbLinks();
        $className      = UsniAdaptor::app()->getModule('cms')->viewHelper->getInstance('pageView');
        $view           = new $className(['page' => $this->page]);      
        $content        = $this->renderInnerContent([$view]);
        return $this->render(FrontUtil::getDefaultInnerLayout(), ['content' => $content]);
    }
    
    /**
     * @inheritdoc
     */
    public function pageTitles()
    {
        $this->page     = PageUtil::getPageByAlias(UsniAdaptor::app()->request->get('alias'));
        return ['page' => $this->page['name']];
    }
}
