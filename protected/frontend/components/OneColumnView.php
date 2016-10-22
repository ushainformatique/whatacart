<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace frontend\components;

use usni\UsniAdaptor;
use frontend\utils\FrontUtil;
/**
 * OneColumnView class file
 *
 * @package frontend\components
 */
class OneColumnView extends FrontColumnView
{
    /**
     * @inheritdoc
     */
    protected function getViewFile()
    {
        $theme = FrontUtil::getThemeName();
        return UsniAdaptor::getAlias('@webroot/themes/' . $theme . '/views/layouts/singlecolumn.php');
    }
}
?>