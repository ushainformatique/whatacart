<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\catalog\views;

use usni\library\views\UiGridSettingsView;
use usni\UsniAdaptor;
/**
 * CatalogGridSettingsView class file.
 * @package common\modules\catalog\views
 */
class CatalogGridSettingsView extends UiGridSettingsView
{
    /**
     * @inheritdoc
     */
    protected function getGridSettingsViewUrl()
    {
        $controllerId   = UsniAdaptor::app()->controller->id;
        $moduleId       = UsniAdaptor::app()->controller->module->id;
        return UsniAdaptor::createUrl('/catalog/' . $moduleId . '/' . $controllerId . '/grid-view-settings');
    }
}
