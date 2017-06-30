<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace products\grid;

use usni\library\grid\ActionColumn;
use products\models\ProductReview;
use usni\library\utils\Html;
use usni\UsniAdaptor;
use usni\fontawesome\FA;
/**
 * ProductReviewActionColumn class file.
 *
 * @package products\grid
 */
class ProductReviewActionColumn extends ActionColumn
{
    /**
     * @inheritdoc
     */
    protected function initDefaultButtons()
    {
        parent::initDefaultButtons();
        if (!isset($this->buttons['approve']))
        {
            $this->buttons['approve'] = array($this, 'renderApproveUnapproveUrlLink');
        }
        if(!isset($this->buttons['spam']))
        {
            $this->buttons['spam'] = array($this, 'renderSpamUrlLink');
        }
        if(!isset($this->buttons['deletetrash']))
        {
            $this->buttons['deletetrash'] = array($this, 'renderDeleteFromTrashLink');
        }
        if(!isset($this->buttons['undo']))
        {
            $this->buttons['undo'] = array($this, 'renderUndoFromTrashLink');
        }
    }
    
    /**
     * Renders approve/unapprove url link.
     * @param string $url
     * @param Model $model
     * @param string $key
     * @return string
     */
    public function renderApproveUnapproveUrlLink($url, $model, $key)
    {
        if($this->checkAccess($model, 'approve'))
        {
            if($model['status'] == ProductReview::STATUS_PENDING)
            {
                $label  = UsniAdaptor::t('products', 'Approve');
                $icon   = FA::icon('check');
                return Html::a($icon, '#', ['class' => 'approve-review-link', 'title' => $label]);
            }
            else
            {
                $label  = UsniAdaptor::t('products', 'Unapprove');
                $icon   = FA::icon('remove');
                return Html::a($icon, '#', ['class' => 'unapprove-review-link', 'title' => $label]);
            }
        }
        return null;
    }
    
    /**
     * Renders spam url link.
     * @param string $url
     * @param Model $model
     * @param string $key
     * @return string
     */
    public function renderSpamUrlLink($url, $model, $key)
    {
        if($this->checkAccess($model, 'spam'))
        {
            if($model['status'] == ProductReview::STATUS_SPAM)
            {
                $label   = UsniAdaptor::t('products', 'Not Spam');
                $icon    = FA::icon('comments-o');
                return Html::a($icon, '#', ['class' => 'remove-spam-review-link', 'title' => $label]);
            }
            else
            {
                $label   = UsniAdaptor::t('products', 'Spam');
                $icon    = FA::icon('exclamation');
                return Html::a($icon, '#', ['class' => 'spam-review-link', 'title' => $label]);
            }
        }
        return null;
    }
    
    /**
     * @inheritdoc
     */
    public function renderDeleteActionLink($url, $model, $key)
    {
        if($this->checkAccess($model, 'delete'))
        {
            $url  = UsniAdaptor::createUrl('catalog/products/review/delete-from-grid', ['id' => $model['id']]);
            $icon = FA::icon('trash-o');
            return Html::a($icon, $url, [
                        'title' => \Yii::t('yii', 'Delete'),
                        'data-confirm' => \Yii::t('yii', 'Are you sure you want to delete this item?'),
                        'data-method' => 'post',
                        'data-pjax' => '0',
                    ]);
        }
        return null;
    }
    
    /**
     * Renders delete from trash link.
     * @param string $url
     * @param Model $model
     * @param string $key
     * @return string
     */
    public function renderDeleteFromTrashLink($url, $model, $key)
    {
        if($this->checkAccess($model, 'delete'))
        {
            $url  = UsniAdaptor::createUrl('catalog/products/review/delete-from-trash', ['id' => $model['id']]);
            $icon = FA::icon('trash-o');
            return Html::a($icon, $url, [
                        'title' => \Yii::t('yii', 'Delete'),
                        'data-confirm' => \Yii::t('yii', 'Are you sure you want to delete this item?'),
                        'data-method' => 'post',
                        'data-pjax' => '0',
                    ]);
        }
        return null;
    }
    
    /**
     * Render undo from trash link.
     * @param string $url
     * @param Model $model
     * @param string $key
     * @return string
     */
    public function renderUndoFromTrashLink($url, $model, $key)
    {
        if($this->checkAccess($model, 'delete'))
        {
            $url  = UsniAdaptor::createUrl('catalog/products/review/undo', ['id' => $model['id']]);
            $icon = FA::icon('mail-reply');
            return Html::a($icon, $url, [
                        'title' => \Yii::t('yii', 'Undo'),
                        'data-pjax' => '0',
                    ]);
        }
        return null;
    }
}
