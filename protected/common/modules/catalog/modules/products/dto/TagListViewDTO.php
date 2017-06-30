<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace products\dto;
/**
 * Data transfer object for tags
 *
 * @package products\dto
 */
class TagListViewDTO extends \frontend\dto\ListViewDTO
{
    /**
     * @var array 
     */
    private $_tagList;
    
    public function getTagList()
    {
        return $this->_tagList;
    }

    public function setTagList($tagList)
    {
        $this->_tagList = $tagList;
    }
}
