<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace backend\views\install;

use usni\UsniAdaptor;
/**
 * Extends install settings view functionality specific to application
 * 
 * @package backend\views\install
 */
class InstallSettingsView extends \usni\library\modules\install\views\InstallSettingsView
{
    /**
     * @inheritdoc
     */
    protected function getHeaderContent()
    {
        return '<div class="page-header">
                            <div class="page-title">
                                <h3>WhatACart ' . UsniAdaptor::t('application', 'Installation') . '</h3>
                            </div>
                        </div>';
    }
}
