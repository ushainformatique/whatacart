<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license http://www.gnu.org/licenses/gpl.html
 */
namespace common\modules\order\utils;

use usni\library\utils\CountryUtil;
/**
 * OrderUtil class file.
 * 
 * @package common\modules\order\utils
 */
class OrderUtil
{
    /**
     * Get concatenated address
     * @param Object|Array $addressModel
     * @return string
     */
    public static function getConcatenatedAddress($addressModel)
    {
        if(is_array($addressModel))
        {
            $addressModel = (object)$addressModel;
        }
        $address = "$addressModel->firstname $addressModel->lastname <br>";
        if($addressModel->address1 != null)
        {
            $address .= "$addressModel->address1 <br>";
        }
        if($addressModel->address2 != null)
        {
            $address .= "$addressModel->address2 <br>";
        }
        if($addressModel->city != null)
        {
            $address .= "$addressModel->city <br>";
        }
        if($addressModel->postal_code != null)
        {
            $address .= "$addressModel->postal_code <br>";
        }
        if($addressModel->state != null)
        {
            $address .= "$addressModel->state <br>";
        }
        if($addressModel->country != null)
        {
            $country = CountryUtil::getCountryName($addressModel->country);
            $address .= "$country <br>";
        }
        return $address;
    }
}
