<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace common\modules\cms\views;

use common\modules\cms\models\Page;
use frontend\views\FrontPageView;
use usni\library\components\UiHtml;
/**
 * PageView class file.
 *
 * @package common\modules\cms\views
 */
class PageView extends FrontPageView
{
    /**
     * @var Page 
     */
    public $page;
    
    /**
     * @inheritdoc
     */
    protected function renderInnerContent()
    {
        $page = $this->page;
        return UiHtml::tag('h1', $page['name']) . $page['content'];
    }
}
