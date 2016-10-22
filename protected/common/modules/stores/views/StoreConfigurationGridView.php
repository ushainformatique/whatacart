<?php
/**
 * StoreConfigurationGridView class file
 *
 * @package 
 */
class StoreConfigurationGridView extends UiGridView
{

    /**
     * Get view columns.
     * @return array
     */
    public function getColumns()
    {
        return array(
            		'id',
		'store_id',
		'key',
		'value',
            array('class' => 'UiBootstrapButtonColumn')
        );
    }
}
?>