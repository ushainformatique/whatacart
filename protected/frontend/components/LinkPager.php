<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace frontend\components;

use usni\library\components\UiHtml;
/**
 * LinkPager class file.
 * @package frontend\components
 */
class LinkPager extends \usni\library\extensions\bootstrap\widgets\UiLinkPager
{
    /**
     * @inheritdoc
     */
    protected function wrapButtons($buttons)
    {
        $content = UiHtml::tag('div', '', ['class' => 'clearfix']);
        return $content . UiHtml::tag('div', UiHtml::tag('ul', implode("\n", $buttons), $this->options));
    }
}
?>