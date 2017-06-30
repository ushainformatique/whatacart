<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace taxes\dto;

/**
 * TaxRuleFormDTO class file.
 *
 * @package taxes\dto
 */
class TaxRuleFormDTO extends \usni\library\dto\FormDTO
{
    /**
     * @var array 
     */
    private $_productTaxClassDropdownData;
    
    /**
     * @var array 
     */
    private $_customerGroupsDropdownData;
    
    /**
     * @var array 
     */
    private $_taxZonesDropdownData;
    
    function getProductTaxClassDropdownData()
    {
        return $this->_productTaxClassDropdownData;
    }

    function setProductTaxClassDropdownData($productTaxClassDropdownData)
    {
        $this->_productTaxClassDropdownData = $productTaxClassDropdownData;
    }
    
    function getCustomerGroupsDropdownData()
    {
        return $this->_customerGroupsDropdownData;
    }

    function getTaxZonesDropdownData()
    {
        return $this->_taxZonesDropdownData;
    }

    function setCustomerGroupsDropdownData($customerGroupsDropdownData)
    {
        $this->_customerGroupsDropdownData = $customerGroupsDropdownData;
    }

    function setTaxZonesDropdownData($taxZonesDropdownData)
    {
        $this->_taxZonesDropdownData = $taxZonesDropdownData;
    }
}
