<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace customer\dto;

use usni\library\modules\users\dto\UserDetailViewDTO;
/**
 * CustomerDetailViewDTO class file.
 * 
 * @package customer\dto
 */
class CustomerDetailViewDTO extends UserDetailViewDTO
{
     /**
     * @var array 
     */
    private $_customerGroups;
    
    public function getCustomerGroups()
    {
        return $this->_customerGroups;
    }

    public function setCustomerGroups($_customerGroups)
    {
        $this->_customerGroups = $_customerGroups;
    }
}
