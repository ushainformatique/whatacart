<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace cart\widgets;

/**
 * HeaderCartSubView class file.
 * 
 * @package cart\widgets
 */
class HeaderCartSubView extends CartSubView
{
    /**
     * inheritdoc
     */
    public $fullView = '//cart/_headercart';
    
    /**
     * inheritdoc
     */
    public $itemView = '//cart/_miniitem';
    
    /**
     * Get full view params
     * @return array
     */
    protected function getFullViewParams()
    {
        $params = parent::getFullViewParams();
        $params['itemCost'] = $this->totalUnitPrice + $this->totalTax;
        return $params;
    }
}