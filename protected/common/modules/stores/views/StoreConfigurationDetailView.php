<?php
/**
 * StoreConfigurationDetailView class file
 *
 * @package 
 */
class StoreConfigurationDetailView extends UiDetailView
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
        );
    }

    /**
     * Get title.
     * @return string
     */
    protected function getTitle()
    {
        return $this->model->name;
    }
}
?>