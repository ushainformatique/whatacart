<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace frontend\controllers;

use frontend\utils\FrontUtil;
use usni\UsniAdaptor;
use usni\library\views\UiView;
/**
 * BaseController class file
 *
 * @package frontend\controllers
 */
class BaseController extends UiWebController
{
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        if(UsniAdaptor::app()->isInstalled())
        {
            $this->layout = FrontUtil::getDefaultViewLayout();
        }
        else
        {
            $this->layout = "@webroot/themes/classic/views/layouts/newmain";
        }
    }
    
    /**
     * Renders inner content.
     * @param array $inputViews
     * @return string
     */
    public function renderInnerContent($inputViews)
    {
        $content = null;
        if(is_object($inputViews) && $inputViews instanceof UiView)
        {
            $content .= $inputViews->render();
        }
        if(is_array($inputViews))
        {
            foreach ($inputViews as $inputView)
            {
                if(is_string($inputView))
                {
                    $content .= $inputView;
                }
                elseif($inputView instanceof UiView)
                {
                    $content .= $inputView->render();
                }
            }
        }
        return $content;
    }
}
