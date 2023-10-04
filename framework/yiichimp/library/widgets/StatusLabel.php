<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\widgets;

use usni\library\db\ActiveRecord;
use usni\library\bootstrap\Label;
use usni\library\utils\Html;
use usni\library\utils\StatusUtil;
use usni\UsniAdaptor;
/**
 * Label for the status
 *
 * @package usni\library\widgets
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
        if ($this->model['status'] == StatusUtil::STATUS_ACTIVE)
        {
            return Label::widget(['content' => $value, 'modifier' => Html::COLOR_SUCCESS, 'id' => $id]);
        }
        elseif ($this->model['status'] == StatusUtil::STATUS_INACTIVE)
        {
            return Label::widget(['content' => $value, 'modifier' => Html::COLOR_WARNING, 'id' => $id]);
        }
        elseif ($this->model['status'] == StatusUtil::STATUS_PENDING)
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
        if ($this->model['status'] == StatusUtil::STATUS_ACTIVE)
        {
            return UsniAdaptor::t('application', 'Active');
        }
        elseif($this->model['status'] == StatusUtil::STATUS_INACTIVE)
        {
            return UsniAdaptor::t('application', 'Inactive');
        }
        elseif ($this->model['status'] == StatusUtil::STATUS_PENDING)
        {
            return UsniAdaptor::t('application', 'Pending');
        }
    }
}