<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\localization\views;

use usni\library\views\UiGridSettingsView;
use usni\UsniAdaptor;
/**
 * LocalizationGridSettingsView class file.
 * @package common\modules\localization\views
 */
class LocalizationGridSettingsView extends UiGridSettingsView
{
    /**
     * @inheritdoc
     */
    protected function getGridSettingsViewUrl()
    {
        $controllerId   = UsniAdaptor::app()->controller->id;
        $moduleId       = UsniAdaptor::app()->controller->module->id;
        return UsniAdaptor::createUrl('/localization/' . $moduleId . '/' . $controllerId . '/grid-view-settings');
    }
}
