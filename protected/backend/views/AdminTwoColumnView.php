<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace backend\views;

use usni\library\views\UiTwoColumnView;
use usni\UsniAdaptor;

/**
 * Two column view for admin panel of ecommerce.
 * 
 * @package backend\views
 */
class AdminTwoColumnView extends UiTwoColumnView
{
    /**
     * @inheritdoc
     */
    protected function renderFooter()
    {
        return $this->getView()->renderPhpFile(UsniAdaptor::getAlias('@backend/views/site/_footer') . '.php', []);
    }
}