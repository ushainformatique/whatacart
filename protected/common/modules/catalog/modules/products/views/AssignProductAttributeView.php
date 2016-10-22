<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace products\views;

use products\views\AssignProductAttributeGridView;
/**
 * AssignProductAttributeView class file.
 * @package products\views
 */
class AssignProductAttributeView extends AssignProductAttributeGridView
{
    /**
     * @inheritdoc
     */
    public function getColumns()
    {
        $columns = [
                       'name',
                       'attribute_value'
                   ];
        return $columns;
    }
    
    /**
     * @inheritdoc
     */
    protected function getLayout()
    {
        if($this->layout == null)
        {
            return "<div class='panel panel-default'>"
                        . "<div class='dataTable'>"
                            . "<div class='datatable-scroll'>{items}</div>"
                            . "<div class='datatable-footer'>{summary}</div>"
                        . "</div>"
                    . "</div>";
        }
        return $this->layout;
    }
    
    /**
     * @inheritdoc
     */
    protected function renderCheckboxColumn()
    {
        return false;
    }
}
?>