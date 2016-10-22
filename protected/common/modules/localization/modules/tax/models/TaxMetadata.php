<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Description of TaxRequest
 *
 * @author a
 */
class TaxMetadata
{
    private $countryId;
    private $regionId;
    private $customerTaxClass;
    private $postCode;
    private $storeId;
    
    public function getCountryId()
    {
        return $this->countryId;
    }

    public function getRegionId()
    {
        return $this->regionId;
    }

    public function getCustomerTaxClass()
    {
        return $this->customerTaxClass;
    }

    public function getPostCode()
    {
        return $this->postCode;
    }

    public function getStoreId()
    {
        return $this->storeId;
    }

    public function setCountryId($countryId)
    {
        $this->countryId = $countryId;
    }

    public function setRegionId($regionId)
    {
        $this->regionId = $regionId;
    }

    public function setCustomerTaxClass($customerTaxClass)
    {
        $this->customerTaxClass = $customerTaxClass;
    }

    public function setPostCode($postCode)
    {
        $this->postCode = $postCode;
    }

    public function setStoreId($storeId)
    {
        $this->storeId = $storeId;
    }
}
