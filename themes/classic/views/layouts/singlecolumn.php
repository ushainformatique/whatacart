<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
use frontend\components\FrontColumnView;
use frontend\assets\AppAsset;

AppAsset::register($this);
$columnView = new FrontColumnView();
echo $columnView->renderHeader();
echo $columnView->renderNavBar();
echo $columnView->renderBreadcrumb($this);
echo $content;
echo $columnView->renderFooter();
?>
