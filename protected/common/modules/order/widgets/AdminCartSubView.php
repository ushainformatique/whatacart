<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\order\widgets;

/**
 * AdminCartSubView class file.
 * 
 * @package common\modules\order\widgets
 */
class AdminCartSubView extends \cart\widgets\CartSubView
{
    /**
     * inheritdoc
     */
    public $fullView = '/_adminCartDetails';
    
    /**
     * inheritdoc
     */
    public $itemView = '/_cartitem';
    
    /**
     * @inheritdoc
     */
    protected function getFullViewParams()
    {
        $params = parent::getFullViewParams();
        $params['isConfirm']    = $this->isConfirm;
        return $params;
    }
    
    /**
     * @inheritdoc
     */
    protected function renderEmptyText()
    {
        return null;
    }
}