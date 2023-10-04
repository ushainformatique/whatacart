<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\modules\notification\widgets;

use usni\library\db\ActiveRecord;
use usni\library\bootstrap\Label;
use usni\library\utils\Html;
use usni\UsniAdaptor;
use usni\library\modules\notification\models\Notification;
/**
 * Label for the status
 *
 * @package usni\library\modules\notification\widgets
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
        if ($this->model['status'] == Notification::STATUS_SENT)
        {
            return Label::widget(['content' => $value, 'modifier' => Html::COLOR_SUCCESS]);
        }
        elseif ($this->model['status'] == Notification::STATUS_PENDING)
        {
            return Label::widget(['content' => $value, 'modifier' => Html::COLOR_DANGER]);
        }
    }
    
    /**
     * Gets label for the status.
     * @return string
     */
    public function getLabel()
    {
        if ($this->model['status'] == Notification::STATUS_SENT)
        {
            return UsniAdaptor::t('application', 'Sent');
        }
        elseif($this->model['status'] == Notification::STATUS_PENDING)
        {
            return UsniAdaptor::t('application', 'Pending');
        }
    }
}
