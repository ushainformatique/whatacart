<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\widgets;

use usni\library\utils\Html;
/**
 * LinkPager extends the functionality to meet the application requirements.
 * 
 * @package usni\library\extensions\bootstrap\widgets
 */
class LinkPager extends \yii\widgets\LinkPager
{
    /**
     * @var integer maximum number of page buttons that can be displayed.
     */
    public $maxButtonCount = 5;
    /**
     * @var string the text label for the next page button.
     */
    public $nextPageLabel = '&rsaquo;';
    /**
     * @var string the text label for the previous page button.
     */
    public $prevPageLabel = '&lsaquo;';
    /**
     * @var string the text label for the first page button.
     */
    public $firstPageLabel = '&laquo;';
    /**
     * @var string the text label for the last page button.
     */
    public $lastPageLabel = '&raquo;';

    /**
     * Renders the page buttons.
     * @return string the rendering result
     */
    protected function renderPageButtons()
    {
        $pageCount = $this->pagination->getPageCount();
        if ($pageCount < 2 && $this->hideOnSinglePage) {
            return '';
        }

        $buttons = [];
        $currentPage = $this->pagination->getPage();

        // first page
        if ($this->firstPageLabel !== false) {
            $buttons[] = $this->renderPageButton($this->firstPageLabel, 0, $this->firstPageCssClass, $currentPage <= 0, false);
        }

        // prev page
        if ($this->prevPageLabel !== false) {
            if (($page = $currentPage - 1) < 0) {
                $page = 0;
            }
            $buttons[] = $this->renderPageButton($this->prevPageLabel, $page, $this->prevPageCssClass, $currentPage <= 0, false);
        }

        // internal pages
        list($beginPage, $endPage) = $this->getPageRange();
        for ($i = $beginPage; $i <= $endPage; ++$i) {
            $buttons[] = $this->renderPageButton($i + 1, $i, null, false, $i == $currentPage);
        }

        // next page
        if ($this->nextPageLabel !== false) {
            if (($page = $currentPage + 1) >= $pageCount - 1) {
                $page = $pageCount - 1;
            }
            $buttons[] = $this->renderPageButton($this->nextPageLabel, $page, $this->nextPageCssClass, $currentPage >= $pageCount - 1, false);
        }

        // last page
        if ($this->lastPageLabel !== false) {
            $buttons[] = $this->renderPageButton($this->lastPageLabel, $pageCount - 1, $this->lastPageCssClass, $currentPage >= $pageCount - 1, false);
        }

        return $this->wrapButtons($buttons);
    }

    /**
     * Wrap buttons.
     * @param array $buttons
     * @return string
     */
    protected function wrapButtons($buttons)
    {
        return Html::tag('div', Html::tag('ul', implode("\n", $buttons), $this->options),
                                                     array('class' => 'dataTables_paginate'));
    }
}
