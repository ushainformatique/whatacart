<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\modules\auth\dto;

/**
 * Data transfer object for group grid view.
 *
 * @package usni\library\modules\auth\dto
 */
class GridViewDTO extends \usni\library\dto\GridViewDTO
{
    /**
     * Level filter data
     * @var array 
     */
    private $_levelFilterData;
    
    public function getLevelFilterData()
    {
        return $this->_levelFilterData;
    }

    public function setLevelFilterData($levelFilterData)
    {
        $this->_levelFilterData = $levelFilterData;
    }
}