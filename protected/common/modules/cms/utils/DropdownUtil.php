<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\cms\utils;

use usni\UsniAdaptor;
use usni\library\components\UiHtml;
use usni\library\extensions\bootstrap\widgets\UiLabel;
use common\modules\cms\Module;
/**
 * DropdownUtil class file
 * 
 * @package common\modules\cms\utils
 */
class DropdownUtil
{
    /**
     * Gets status dropdown for post.
     * @return array
     */
    public static function getStatusSelectOptions()
    {
        return [
                    Module::STATUS_PUBLISHED      => UsniAdaptor::t('cms', 'Published'),
                    Module::STATUS_UNPUBLISHED    => UsniAdaptor::t('cms', 'Unpublished'),
                    Module::STATUS_ARCHIVED       => UsniAdaptor::t('cms', 'Archived'),
                    Module::STATUS_TRASHED        => UsniAdaptor::t('cms', 'Trashed'),
               ];
    }

    /**
     * Renders label for the status.
     * @param string $data ActiveRecord of the model.
     * @return string
     */
    public static function renderLabel($data)
    {
        $value      = self::getLabel($data);
        if ($value == UsniAdaptor::t('cms', 'Published'))
        {
            return UiLabel::widget(['content' => $value, 'modifier' => UiHtml::COLOR_SUCCESS]);
        }
        elseif ($value == UsniAdaptor::t('cms', 'Unpublished'))
        {
            return UiLabel::widget(['content' => $value, 'modifier' => UiHtml::COLOR_WARNING]);
        }
        elseif ($value == UsniAdaptor::t('cms', 'Archived'))
        {
            return UiLabel::widget(['content' => $value, 'modifier' => UiHtml::COLOR_DANGER]);
        }
        elseif ($value == UsniAdaptor::t('cms', 'Trashed'))
        {
            return UiLabel::widget(['content' => $value, 'modifier' => UiHtml::COLOR_DANGER]);
        }
    }
    
    /**
     * Gets label for the status.
     * @param string $data ActiveRecord of the model.
     * @return string
     */
    public static function getLabel($data)
    {
        if ($data['status'] == Module::STATUS_PUBLISHED)
        {
            return UsniAdaptor::t('cms', 'Published');
        }
        else if ($data['status'] == Module::STATUS_UNPUBLISHED)
        {
            return UsniAdaptor::t('cms', 'Unpublished');
        }
        else if ($data['status'] == Module::STATUS_ARCHIVED)
        {
            return UsniAdaptor::t('cms', 'Archived');
        }
        else if($data['status'] == Module::STATUS_TRASHED)
        {
            return UsniAdaptor::t('cms', 'Trashed');
        }
    }
}