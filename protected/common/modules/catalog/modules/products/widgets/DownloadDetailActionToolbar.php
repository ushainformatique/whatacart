<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace products\widgets;

use usni\fontawesome\FA;
use usni\UsniAdaptor;
/**
 * DownloadDetailActionToolbar class file.
 *
 * @package products\widgets
 */
class DownloadDetailActionToolbar extends \usni\library\widgets\DetailActionToolbar
{
    /**
     * Download url for the model
     * @var string 
     */
    public $downloadUrl;
    
    /**
     * inheritdoc
     */
    public function getListItems()
    {
        $items[]    = ['label' => FA::icon('pencil') . "\n" . UsniAdaptor::t('application', 'Edit'), 
                       'url' => $this->editUrl];
        $items[]    = ['label' => FA::icon('trash-o') . "\n" . UsniAdaptor::t('application', 'Delete'), 
                       'url' => $this->deleteUrl];
        $items[]    = ['label' => FA::icon('pencil') . "\n" . UsniAdaptor::t('products', 'Download'), 
                       'url' => $this->downloadUrl];
        return $items;
    }
}
