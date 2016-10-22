<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace newsletter\views;

use usni\library\components\TranslatableGridView;
use usni\library\extensions\bootstrap\widgets\UiActionColumn;
/**
 * NewsletterGridView class file.
 * @package common\modules\newsletter\views
 */
class NewsletterGridView extends TranslatableGridView
{
    /**
     * @inheritdoc
     */
    public function getColumns()
    {
        $columns = [
                        'subject',
                        [
                            'attribute' => 'content',
                            'format'    => 'raw',
                        ],
                        [
                            'class'     => UiActionColumn::className(),
                            'template'  => '{view} {delete}'
                        ]
                   ];
        return $columns;
    }
    
    /**
     * @inheritdoc
     */
    protected static function getActionToolbarOptions()
    {
        return [];
    }
}
?>