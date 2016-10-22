<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace products\views\front;

use frontend\views\common\SearchResultsView;
use usni\UsniAdaptor;
/**
 * TagView class file.
 * @package products\views\front
 */
class TagView extends SearchResultsView
{
    /**
     * @inheritdoc
     */
    protected function getTitle()
    {
        return UsniAdaptor::t('application', 'Search Results') . ' - ' . $this->model->tag;
    }
}