<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace frontend\widgets;

use usni\library\components\UiHtml;
use usni\library\widgets\UiListViewWidget;
/**
 * UiListViewWidget class file
 * @package frontend\widgets
 */
class UiFrontListViewWidget extends UiListViewWidget
{
    /**
     * @inheritdoc
     */
    public function renderCaption()
    {
        if (!empty($this->caption))
        {
            $caption = UiHtml::tag('h3', $this->caption, $this->captionOptions);
            return UiHtml::tag('div', $caption);
        }
        return null;
    }
}
?>