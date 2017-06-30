<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\localization\modules\orderstatus\widgets;

use usni\UsniAdaptor;
use usni\library\bootstrap\Label;
use usni\library\utils\Html;
/**
 * Label for the status
 *
 * @package common\modules\localization\modules\orderstatus\widgets
 */
class StatusLabel extends \yii\bootstrap\Widget
{
    use \common\modules\localization\modules\orderstatus\traits\OrderStatusTrait;
    
    /**
     * @var ActiveRecord|array 
     */
    public $model;
    
    /**
     * @var string 
     */
    public $language;
    
    /**
     * inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->language = UsniAdaptor::app()->languageManager->selectedLanguage;
    }

    /**
     * inheritdoc
     */
    public function run()
    {
        $value      = $this->getOrderStatusLabel($this->model['status'], $this->language);
        $id         = $this->model['id'] . '-status';
        return $this->getLabelWidget($value, $id);
    }
    
    /**
     * Get label widget
     * @param string $value
     * @param string $id
     * @return string
     */
    public function getLabelWidget($value, $id)
    {
        $labelWidget = null;
        if ($value == UsniAdaptor::t('order', 'Completed'))
        {
            $labelWidget = Label::widget(['content' => $value, 'modifier' => Html::COLOR_SUCCESS, 'id' => $id]);
        }
        elseif ($value == UsniAdaptor::t('order', 'Pending'))
        {
            $labelWidget = Label::widget(['content' => $value, 'modifier' => Html::COLOR_DEFAULT, 'id' => $id]);
        }
        elseif ($value == UsniAdaptor::t('order', 'Cancelled'))
        {
            $labelWidget = Label::widget(['content' => $value, 'modifier' => Html::COLOR_DANGER, 'id' => $id]);
        }
        elseif ($value == UsniAdaptor::t('order', 'Cancelled Reversal'))
        {
            $labelWidget = Label::widget(['content' => $value, 'modifier' => Html::COLOR_DEFAULT, 'id' => $id]);
        }
        elseif ($value == UsniAdaptor::t('order', 'Chargeback'))
        {
            $labelWidget = Label::widget(['content' => $value, 'modifier' => Html::COLOR_DEFAULT, 'id' => $id]);
        }
        elseif ($value == UsniAdaptor::t('order', 'Denied'))
        {
            $labelWidget = Label::widget(['content' => $value, 'modifier' => Html::COLOR_DEFAULT, 'id' => $id]);
        }
        elseif ($value == UsniAdaptor::t('order', 'Expired'))
        {
            $labelWidget = Label::widget(['content' => $value, 'modifier' => Html::COLOR_DEFAULT, 'id' => $id]);
        }
        elseif ($value == UsniAdaptor::t('order', 'Failed'))
        {
            $labelWidget = Label::widget(['content' => $value, 'modifier' => Html::COLOR_DEFAULT, 'id' => $id]);
        }
        elseif ($value == UsniAdaptor::t('order', 'Processed'))
        {
            $labelWidget = Label::widget(['content' => $value, 'modifier' => Html::COLOR_DEFAULT, 'id' => $id]);
        }
        elseif ($value == UsniAdaptor::t('order', 'Processing'))
        {
            $labelWidget = Label::widget(['content' => $value, 'modifier' => Html::COLOR_DEFAULT, 'id' => $id]);
        }
        elseif ($value == UsniAdaptor::t('order', 'Refunded'))
        {
            $labelWidget = Label::widget(['content' => $value, 'modifier' => Html::COLOR_INFO, 'id' => $id]);
        }
        elseif ($value == UsniAdaptor::t('order', 'Reversed'))
        {
            $labelWidget = Label::widget(['content' => $value, 'modifier' => Html::COLOR_WARNING, 'id' => $id]);
        }
        elseif ($value == UsniAdaptor::t('order', 'Shipped'))
        {
            $labelWidget = Label::widget(['content' => $value, 'modifier' => Html::COLOR_DEFAULT, 'id' => $id]);
        }
        elseif ($value == UsniAdaptor::t('order', 'Voided'))
        {
            $labelWidget = Label::widget(['content' => $value, 'modifier' => Html::COLOR_DANGER, 'id' => $id]);
        }
        return $labelWidget;
    }
}