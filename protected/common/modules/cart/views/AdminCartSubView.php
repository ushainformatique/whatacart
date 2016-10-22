<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace cart\views;

use usni\UsniAdaptor;
/**
 * AdminCartSubView class file.
 * 
 * @package cart\views
 */
class AdminCartSubView extends CartSubView
{
    /**
     * @inheritdoc
     */
    protected function getFullViewParams()
    {
        $params = parent::getFullViewParams();
        $params['isConfirm']    = $this->getIsConfirm();
        return $params;
    }
    
    /**
     * @inheritdoc
     */
    protected function getItemViewFile()
    {
        return UsniAdaptor::getAlias('@common/modules/cart/views/_cartitem.php');
    }
    
    /**
     * @inheritdoc
     */
    protected function getFullViewFile()
    {
        return UsniAdaptor::getAlias('@common/modules/cart/views/_adminCartDetails.php');
    }
    
    /**
     * @inheritdoc
     */
    protected function getButtons()
    {
        return null;
    }
    
    /**
     * Is on confirm screen
     * @return boolean
     */
    protected function getIsConfirm()
    {
        return false;
    }
    
    /**
     * @inheritdoc
     */
    protected function renderEmptyText()
    {
        return null;
    }
}