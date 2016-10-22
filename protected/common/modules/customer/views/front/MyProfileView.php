<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace customer\views\front;

use usni\UsniAdaptor;
use frontend\utils\FrontUtil;
/**
 * MyProfileView class file.
 * @package customer\views\front
 */
class MyProfileView extends AccountPageView
{
    /**
     * @inheritdoc
     */
    protected function renderInnerContent()
    {
        $theme        = FrontUtil::getThemeName();
        $file         = UsniAdaptor::getAlias('@themes/' . $theme . '/views/customers/account') . '.php';
        return $this->getView()->renderPhpFile($file, ['model' => $this->model]);
    }
}
?>