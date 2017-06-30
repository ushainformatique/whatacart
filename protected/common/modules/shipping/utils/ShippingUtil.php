<?php
namespace common\modules\shipping\utils;

use usni\UsniAdaptor;
use common\modules\extension\models\Extension;
/**
 * ShippingUtil class file.
 * 
 * @package common\modules\shipping\utils
 */
class ShippingUtil
{
    /**
     * Gets status dropdown.
     * @return array
     */
    public static function getStatusDropdown()
    {
        return array(
            Extension::STATUS_ACTIVE     => UsniAdaptor::t('application','Active'),
            Extension::STATUS_INACTIVE   => UsniAdaptor::t('application','Inactive')
        );
    }
}