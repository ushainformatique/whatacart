<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace frontend\modules\site\views;

use usni\library\views\UiView;
use usni\UsniAdaptor;
use frontend\utils\FrontUtil;
/**
 * CarouselView class file
 *
 * @package frontend\modules\site\views
 */
class CarouselView extends UiView
{
    /**
     * Render content
     */
    protected function renderContent()
    {
        $themeName       = FrontUtil::getThemeName();
        $file            = UsniAdaptor::getAlias('@themes/' . $themeName . '/views/home/_carousel') . '.php';
        return $this->getView()->renderPhpFile($file);
    }
}
?>