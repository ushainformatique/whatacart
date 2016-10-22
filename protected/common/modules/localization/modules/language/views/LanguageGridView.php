<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace common\modules\localization\modules\language\views;

use usni\library\components\UiGridView;
use common\modules\localization\components\LocalizationNameDataColumn;
use usni\library\widgets\UiStatusDataColumn;
use usni\library\utils\StatusUtil;
use common\modules\localization\modules\language\components\LanguageActionColumn;
/**
 * LanguageGridView class file
 * 
 * @package common\modules\localization\modules\language\views
 */
class LanguageGridView extends UiGridView
{
    /**
     * @inheritdoc
     */
    public function getColumns()
    {
        $columns = [
                      [
                          'attribute' => 'name',
                          'class'     => LocalizationNameDataColumn::className()
                      ],
                          'code',
                          'locale',
                      [
                            'attribute' => 'status',
                            'class'     => UiStatusDataColumn::className(),
                            'filter'    => StatusUtil::getDropdown()
                      ],
                      [
                          'class'     => LanguageActionColumn::className(),
                          'template'  => '{view} {update} {delete}'
                      ]
                   ];
        return $columns;
    }
}