<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace common\modules\dataCategories\components;

use usni\library\extensions\bootstrap\widgets\UiActionColumn;
use usni\UsniAdaptor;
use usni\library\components\UiHtml;
use usni\fontawesome\FA;
use common\modules\dataCategories\models\DataCategory;
/**
 * DataCategoryActionColumn class file.
 *
 * @package common\modules\dataCategories\components
 */
class DataCategoryActionColumn extends UiActionColumn
{
    /**
     * @inheritdoc
     */
    protected function renderDeleteActionLink($url, $model, $key)
    {
        if($model['id'] != DataCategory::ROOT_CATEGORY_ID)
        {
            if($this->checkAccess($model, 'delete'))
            {
                $shortName = strtolower(UsniAdaptor::getObjectClassName($this->grid->owner->model));
                $icon = FA::icon('trash-o');
                return UiHtml::a($icon, $url, [
                            'title' => \Yii::t('yii', 'Delete'),
                            'id'    => 'delete-' . $shortName . '-' . $model['id'],
                            'data-confirm' => \Yii::t('yii', 'Are you sure you want to delete this item?'),
                            'data-method' => 'post',
                            'data-pjax' => '0',
                        ]);
            }
            return null;
        }
        return null;
    }
    
    /**
     * @inheritdoc
     */
    protected function renderUpdateActionLink($url, $model, $key)
    {
        if($model['id'] != DataCategory::ROOT_CATEGORY_ID)
        {
            if($this->checkAccess($model, 'update'))
            {
                $shortName = strtolower(UsniAdaptor::getObjectClassName($this->grid->owner->model));
                $icon = FA::icon('pencil');
                return UiHtml::a($icon, $url, [
                            'title' => \Yii::t('yii', 'Update'),
                            'data-pjax' => '0',
                            'id'        => 'update-' . $shortName . '-' . $model['id'],
                            'class'     => 'update-' . $shortName
                        ]);
            }
            return null;
        }
        return null;
    }
}