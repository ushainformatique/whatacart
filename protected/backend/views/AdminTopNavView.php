<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace backend\views;

use usni\library\views\UiTopNavView;
/**
 * Top nav view for admin panel of ecommerce.
 * @package backend.views
 */
class AdminTopNavView extends UiTopNavView
{
    /**
     * Resolve top navigation file.
     * @return string
     */
    protected function resolveTopNavFile()
    {
        return '@webroot/themes/bootstrap/site/_topnav';
    }
}
?>