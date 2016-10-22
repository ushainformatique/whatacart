<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\extension\views;

use usni\library\widgets\UiStatusDataColumn;
use usni\library\utils\StatusUtil;
use common\modules\extension\components\ExtensionActionColumn;
use usni\library\utils\FlashUtil;
use usni\library\components\TranslatableGridView;
/**
 * ExtensionGridView class file
 * 
 * @package common\modules\extension\views
 */
class ExtensionGridView extends TranslatableGridView
{
    /**
     * @inheritdoc
     */
    public function getColumns()
    {
        $columns = [
                      'name',
                      'code',
                      $this->getCategoryColumn(),
                      'author',
                      'version',
                      'product_version',
                      [
                        'attribute'     => 'status',
                        'class'         => UiStatusDataColumn::className(),
                        'filter'        => StatusUtil::getDropdown()
                      ]
                   ];
        $actionColumn = $this->resolveActionColumn();
        if($actionColumn != null)
        {
            $columns[] = $actionColumn;
        }
        return $columns;
    }
    
    /**
     * Resolve action column
     * @return array
     */
    protected function resolveActionColumn()
    {
        return [
            'class'       => ExtensionActionColumn::className(),
            'template'    => '{settings} {changestatus}'
        ];  
    }

    /**
     * @inheritdoc
     */
    protected static function getActionToolbarOptions()
    {
        return ['showBulkEdit'            => false,
                'showBulkDelete'          => false,
                'showCreate'              => false,
                'showSettings'            => true];
    }
    
    /**
     * @inheritdoc
     */
    protected function renderFlashMessages()
    {
        return FlashUtil::render('settingsRouteMissing', 'alert alert-success');
    }
    
    /**
     * Get category column
     * @return string
     */
    protected function getCategoryColumn()
    {
        return 'category';
    }
}