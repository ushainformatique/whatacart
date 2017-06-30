<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace frontend\dto;
/**
 * Data transfer object for home page
 *
 * @package frontend\dto
 */
class HomePageDTO extends \usni\library\dto\BaseDTO
{
    private $_latestProducts;
    
    public function getLatestProducts()
    {
        return $this->_latestProducts;
    }

    public function setLatestProducts($latestProducts)
    {
        $this->_latestProducts = $latestProducts;
    }
}
