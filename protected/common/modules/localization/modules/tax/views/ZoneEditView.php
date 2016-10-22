<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace taxes\views;

use usni\library\extensions\bootstrap\views\UiBootstrapEditView;
use usni\library\components\UiHtml;
use usni\library\utils\ButtonsUtil;
use usni\library\utils\DAOUtil;
use common\modules\localization\modules\country\models\Country;
use usni\UsniAdaptor;
use usni\library\utils\ArrayUtil;
use usni\library\utils\AdminUtil;
use common\modules\localization\modules\state\utils\StateUtil;
/**
 * ZoneEditView class file
 * @package taxes\views
 */
class ZoneEditView extends UiBootstrapEditView
{

    /**
     * @inheritdoc
     */
    public function getFormBuilderMetadata()
    {
        $countries = DAOUtil::getDropdownDataBasedOnModel(Country::className());
        $countryData[-1] = UsniAdaptor::t('localization', 'All Countries');
        $countryData    = ArrayUtil::merge($countryData, $countries);
        
        //States
        if($this->model->country_id == -1)
        {
            $stateData[-1] = UsniAdaptor::t('localization', 'All States');
        }
        else
        {
            $stateData  = StateUtil::getStatesOptionByCountryId($this->model->country_id);
        }
        if($this->model->is_zip_range == null)
        {
            $this->model->is_zip_range = 0;
        }
        if($this->model->is_zip_range == false)
        {
            $zipContainerStyle = 'display:block';
            $zipRangeContainerStyle = 'display:none';
        }
        else
        {
            $zipContainerStyle = 'display:none';
            $zipRangeContainerStyle = 'display:block';
        }
        $elements = [
                        'name'          => ['type' => 'text'],
                        'description'   => ['type' => 'textarea'],
                        'country_id'    => UiHtml::getFormSelectFieldOptions($countryData),
                        'state_id'      => UiHtml::getFormSelectFieldOptions($stateData),
                        'is_zip_range'  => UiHtml::getFormSelectFieldOptions(AdminUtil::getYesNoOptions()),
                        UiHtml::beginTag('div', ['id' => 'zipContainer', 'style' => $zipContainerStyle]),
                        'zip'           => ['type' => 'text'],
                        UiHtml::endTag('div'),
                        UiHtml::beginTag('div', ['id' => 'zipRangeContainer', 'style' => $zipRangeContainerStyle]),
                        'from_zip'      => ['type' => 'text'],
                        'to_zip'        => ['type' => 'text'],
                        UiHtml::endTag('div'),
                    ];
        $metadata = [
                        'elements'      => $elements,
                        'buttons'       => ButtonsUtil::getDefaultButtonsMetadata('localization/tax/zone/manage')
                    ];
        return $metadata;
    }
    
    /**
     * @inheritdoc
     */
    protected function registerScripts()
    {
        parent::registerScripts();
        $url = UsniAdaptor::createUrl('localization/state/default/get-states-by-country');
        $js = "$('#zone-country_id').on('change', function(){
                var dropDown    = $(this);
                $.ajax({
                        url: '{$url}',
                        type: 'get',
                        data: 'countryId=' + $(this).val(),
                        beforeSend: function()
                                    {
                                        $.fn.attachLoader('#s2id_zone-country_id');
                                    },
                        success: function(data){
                            $.fn.removeLoader('#s2id_zone-country_id');
                            $('#zone-state_id').html(data);
                        }
                    });
                
        }) 
        $('#zone-is_zip_range').on('change', function(){
                var value = $(this).val();
                if(value == 0)
                {
                    $('#zipContainer').show();
                    $('#zipRangeContainer').hide();
                }
                else
                {
                    $('#zipContainer').hide();
                    $('#zipRangeContainer').show();
                }
        })";
        $this->getView()->registerJs($js);
    }
}
?>