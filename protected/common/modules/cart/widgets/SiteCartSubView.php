<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace cart\widgets;

/**
 * SiteCartSubView class file.
 * 
 * @package cart\widgets
 */
class SiteCartSubView extends CartSubView
{
    /**
     * inheritdoc
     */
    public $fullView = '/_cartdetails';
    
    /**
     * inheritdoc
     */
    public $itemView = '/_item';
    
    /**
     * inheritdoc
     */
    public $buttonView = '/_cartbuttons';
}
