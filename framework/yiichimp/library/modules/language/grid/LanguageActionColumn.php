<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace usni\library\modules\language\grid;

use usni\library\utils\Html;
use usni\fontawesome\FA;
use usni\library\grid\ActionColumn;
/**
 * LanguageActionColumn class file.
 *
 * @package usni\library\modules\language\grid
 */
class LanguageActionColumn extends ActionColumn
{
    /**
     * @inheritdoc
     */
    protected function renderDeleteActionLink($url, $model, $key)
    {
        if($model['code'] == 'en-US')
        {
            return null;
        }
        if($this->checkAccess($model, 'delete'))
        {
            $shortName  = strtolower($this->modelClassName);
            $icon       = FA::icon('trash-o');
            return Html::a($icon, $url, [
                        'title' => \Yii::t('yii', 'Delete'),
                        'id'    => 'delete-' . $shortName . '-' . $model['id'],
                        'data-confirm' => \Yii::t('yii', 'Are you sure you want to delete this item?'),
                        'data-method' => 'post',
                        'data-pjax' => '0',
                    ]);
        }
        return null;        
    }
}