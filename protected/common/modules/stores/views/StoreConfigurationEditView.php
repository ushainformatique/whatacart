<?php
/**
 * StoreConfigurationEditView class file
 *
 * @package 
 */
class StoreConfigurationEditView extends UiBootstrapEditView
{

    /**
     * Get Form Builder Meta Data.
     * @return array
     */
    public function getFormBuilderMetadata()
    {
        $elements = array(
            		'id' => array('type' => 'text'),
            		'store_id' => array('type' => 'text'),
            		'key' => array('type' => 'text'),
            		'value' => array('type' => 'text'),
                    );
        $metadata = array(
            'elements'          => $elements,
            'buttons'           => self::getDefaultButtonsMetadata("'/StoreConfiguration/manage'")
        );
        return $metadata;
    }
}
?>