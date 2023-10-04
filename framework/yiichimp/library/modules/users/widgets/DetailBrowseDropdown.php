<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\modules\users\widgets;

/**
 * DetailBrowseDropdown renders detail browse dropdown
 *
 * @package usni\library\modules\users\widgets
 */
class DetailBrowseDropdown extends BrowseDropdown
{
    /**
     * Is detail view in modal display
     * @var boolean 
     */
    public $modalDisplay;
    
    /**
     * inheritdoc
     */
    public function run()
    {
        if($this->modalDisplay == false)
        {
            return parent::run();
        }
        return null;
    }
}
