<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\cms\widgets;

use usni\library\db\ActiveRecord;
use usni\library\bootstrap\Label;
use usni\library\utils\Html;
use usni\UsniAdaptor;
use common\modules\cms\Module;
/**
 * Label for the status
 *
 * @package common\modules\cms\widgets
 */
class StatusLabel extends \yii\bootstrap\Widget
{
    /**
     * @var ActiveRecord|array 
     */
    public $model;
    
    /**
     * inheritdoc
     */
    public function run()
    {
        $id     = $this->model['id'] . '-status';
        $value  = $this->getLabel();
        if ($this->model['status'] == Module::STATUS_PUBLISHED)
        {
            return Label::widget(['content' => $value, 'modifier' => Html::COLOR_SUCCESS, 'id' => $id]);
        }
        elseif ($this->model['status'] == Module::STATUS_UNPUBLISHED)
        {
            return Label::widget(['content' => $value, 'modifier' => Html::COLOR_WARNING, 'id' => $id]);
        }
        elseif ($this->model['status'] == Module::STATUS_ARCHIVED)
        {
            return Label::widget(['content' => $value, 'modifier' => Html::COLOR_DANGER, 'id' => $id]);
        }
        elseif ($this->model['status'] == Module::STATUS_TRASHED)
        {
            return Label::widget(['content' => $value, 'modifier' => Html::COLOR_DANGER, 'id' => $id]);
        }
    }
    
    /**
     * Gets label for the status.
     * @return string
     */
    public function getLabel()
    {
        if ($this->model['status'] == Module::STATUS_PUBLISHED)
        {
            return UsniAdaptor::t('cms', 'Published');
        }
        elseif($this->model['status'] == Module::STATUS_UNPUBLISHED)
        {
            return UsniAdaptor::t('cms', 'Unpublished');
        }
        elseif ($this->model['status'] == Module::STATUS_ARCHIVED)
        {
            return UsniAdaptor::t('cms', 'Archived');
        }
        elseif ($this->model['status'] == Module::STATUS_TRASHED)
        {
            return UsniAdaptor::t('cms', 'Trashed');
        }
    }
}
