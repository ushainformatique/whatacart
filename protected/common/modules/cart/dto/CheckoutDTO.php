<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace cart\dto;

/**
 * CheckoutDTO class file
 *
 * @package cart\dto
 */
class CheckoutDTO extends \common\modules\order\dto\AdminCheckoutDTO
{
    /**
     * @var string 
     */
    private $_terms;
    
    public function getTerms()
    {
        return $this->_terms;
    }

    public function setTerms($terms)
    {
        $this->_terms = $terms;
    }
}
