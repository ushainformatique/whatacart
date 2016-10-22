<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace cart\views;

use frontend\utils\FrontUtil;
use usni\UsniAdaptor;
/**
 * HeaderCartSubView class file.
 * @package cart\views
 */
class HeaderCartSubView extends CartSubView
{
    /**
     * @inheritdoc
     */
    protected function renderContent()
    {
        $rowContent = $this->getCartDetails();
        $buttonContent = $this->getButtons();
        return $rowContent . $buttonContent;
    }
    
    /**
     * Get full view params
     * @return array
     */
    protected function getFullViewParams()
    {
        $params = parent::getFullViewParams();
        $params['itemCost'] = $this->formattedCost;
        return $params;
    }

    /**
     * @inheritdoc
     */
    protected function getItemViewFile()
    {
        $frontTheme         = FrontUtil::getThemeName();
        return UsniAdaptor::getAlias('@themes/' . $frontTheme . '/views/cart/_miniitem.php');
    }
    
    /**
     * @inheritdoc
     */
    protected function getButtonViewFile()
    {
        return null;
    }
    
    /**
     * @inheritdoc
     */
    protected function getFullViewFile()
    {
        $frontTheme         = FrontUtil::getThemeName();
        return UsniAdaptor::getAlias('@themes/' . $frontTheme . '/views/cart/_headercart.php');
    }
}