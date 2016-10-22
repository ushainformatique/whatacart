<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license http://www.gnu.org/licenses/gpl.html
 */
namespace frontend\views;

use frontend\utils\FrontUtil;
use usni\UsniAdaptor;
/**
 * FrontPageView class file.
 * @package frontend\views
 */
abstract class FrontPageView extends \usni\library\views\UiView
{
    /**
     * @inheritdoc
     */
    protected function renderContent()
    {
        return $this->getView()->renderPhpFile($this->getInnerPageFile(), ['columnLeft' => $this->renderLeftColumn(),
                                                                'columnRight'=> $this->renderRightColumn(),
                                                                'content'    => $this->renderInnerContent(),
                                                                'title'      => $this->renderTitle()
                                                               ]);
    }
    
    /**
     * Renders inner content of the page
     * @return string
     */
    protected function renderInnerContent()
    {
        return null;
    }

    /**
     * Renders left column
     * @return string
     */
    protected function renderLeftColumn()
    {
        $content = $this->getLeftColumnContent();
        if($content != null)
        {
            $theme        = FrontUtil::getThemeName();
            $file         = UsniAdaptor::getAlias('@themes/' . $theme . '/views/layouts/sidebarcolumn') . '.php';
            return $this->getView()->renderPhpFile($file, ['position' => 'left',
                                                            'content'    => $content
                                                           ]);
        }
        return null;
    }
    
    /**
     * Get left column content
     * @return string
     */
    protected function getLeftColumnContent()
    {
        return null;
    }

    /**
     * Get right column content
     * @return string
     */
    protected function getRightColumnContent()
    {
        return null;
    }
    
    /**
     * Renders right column
     * @return string
     */
    protected function renderRightColumn()
    {
        $content = $this->getRightColumnContent();
        if($content != null)
        {
            $theme        = FrontUtil::getThemeName();
            $file         = UsniAdaptor::getAlias('@themes/' . $theme . '/views/layouts/sidebarcolumn') . '.php';
            return $this->getView()->renderPhpFile($file, ['position' => 'right',
                                                            'content'    => $content
                                                           ]);
        }
        return null;
    }
    
    /**
     * Renders title
     * @return string
     */
    protected function renderTitle()
    {
        return $this->getView()->title;
    }
    
    /**
     * Get inner page file
     * @return string
     */
    protected function getInnerPageFile()
    {
        $theme        = FrontUtil::getThemeName();
        return UsniAdaptor::getAlias('@themes/' . $theme . '/views/layouts/innerpage') . '.php';
    }
}
?>