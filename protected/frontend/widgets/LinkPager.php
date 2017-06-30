<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace frontend\widgets;

use usni\library\utils\Html;
/**
 * LinkPager class file.
 * 
 * @package frontend\widgets
 */
class LinkPager extends \usni\library\widgets\LinkPager
{
    /**
     * @inheritdoc
     */
    protected function wrapButtons($buttons)
    {
        $content = Html::tag('div', '', ['class' => 'clearfix']);
        return $content . Html::tag('div', Html::tag('ul', implode("\n", $buttons), $this->options));
    }
}