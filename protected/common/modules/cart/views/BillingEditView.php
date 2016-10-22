<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace cart\views;

use usni\library\components\UiHtml;
use usni\library\utils\CountryUtil;

/**
 * BillingEditView class file.
 * 
 * @package cart\views
 */
class BillingEditView extends \usni\library\views\MultiModelEditView
{
    /**
     * Application end into which view is loaded
     * @var string 
     */
    public $source;
    
    /**
     * @inheritdoc
     */
    public function getFormBuilderMetadata()
    {
        $startTag       = UiHtml::beginTag('div', ['class' => 'col-sm-6']);
        $endTag         = UiHtml::endTag('div');
        $startTagRight  = UiHtml::beginTag('div', ['class' => 'col-sm-6']);
        $endTagRight    = UiHtml::endTag('div');
        $elements = array(
                    UiHtml::beginTag('div', ['class' => 'row']),
                    $startTag,
                    'firstname'     => array('type' => 'text'),
                    'lastname'      => array('type' => 'text'),
                    'email'         => array('type' => 'text'),
                    'mobilephone'   => array('type' => 'text'),
                    'address1'      => array('type' => 'text'),
                    $endTag,
                    $startTagRight,
                    'address2'      => array('type' => 'text'),
                    'city'          => array('type' => 'text'),
                    'state'         => array('type' => 'text'),
                    'country'       => UiHtml::getFormSelectFieldOptions(CountryUtil::getCountries()),
                    'postal_code'     => array('type' => 'text'),
                    $endTagRight,
                    UiHtml::endTag('div')
        );
        $metadata = array(
            'elements'              => $elements,
        );
        return $metadata;
    }
    
    /**
     * @inheritdoc
     */
    protected function getDefaultAttributeOptions()
    {
        $options = parent::getDefaultAttributeOptions();
        $options['labelOptions'] = ['class' => 'control-label'];
        return $options;
    }
}