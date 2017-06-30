<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\stores\utils;

/**
 * StoreScriptUtil class file.
 * 
 * @package common\modules\stores\utils
 */
class StoreScriptUtil
{
    /**
     * Register same as billing address script
     * @param View $view
     */
    public static function registerSameAsBillingAddressScript($view)
    {
        $sameAsBillingScript = "$('#shippingaddress-usebillingaddress').change(function(){
                                    var attributes = ['firstname', 'lastname', 'address1', 'city', 'country', 'postal_code', 'state', 'address2', 'email', 'mobilephone'];
                                    var c = this.checked;
                                    if(c)
                                    {
                                          $.each(attributes, function(index, value){
                                            if(value == 'country')
                                            {
                                                var inputValue = $('#billingaddress-' + value).select2('val');
                                                $('#shippingaddress-' + value).select2('val', inputValue);
                                            }
                                            else
                                            {
                                                var inputValue = $('#billingaddress-' + value).val();
                                                $('#shippingaddress-' + value).val(inputValue);
                                            }
                                          });
                                    }
                                })";
        $view->registerJs($sameAsBillingScript);
    }
}