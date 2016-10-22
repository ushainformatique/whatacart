<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace frontend\widgets;

use usni\library\components\UiHtml;
use usni\library\extensions\bootstrap\widgets\UiLinkPager;
/**
 * FrontLinkPager extends the functio.
 * @package frontend\widgets
 */
class FrontLinkPager extends UiLinkPager
{
    /**
     * @inheritdoc
     */
    protected function wrapButtons($buttons)
    {
        return UiHtml::tag('div', UiHtml::tag('ul', implode("\n", $buttons), $this->options),
                                                     array('class' => 'col-md-12'));
    }
}
?>
