<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\web\actions;

use usni\UsniAdaptor;
use usni\library\dto\DetailViewDTO;
use usni\library\widgets\behaviors\DetailBehavior;
use yii\web\ForbiddenHttpException;
/**
 * ViewAction class file. This would handle rendering a model detail.
 *
 * @package usni\library\web\actions
 */
class ViewAction extends Action
{
    /**
     * @var string class name of the [[DetailViewDTO]] which will be used in this action.
     * This property must be set.
     */
    public $detailViewDTOClass;
    
    /**
     * inheritdoc
     */
    public function init()
    {
        if($this->detailViewDTOClass == null)
        {
            $this->detailViewDTOClass = DetailViewDTO::className();
        }
    }
    
    /**
     * Runs the action
     * @param int $id
     * @return string
     */
    public function run($id)
    {
        $detailViewDTO      = new $this->detailViewDTOClass();
        $detailViewDTO->setId($id);
        $detailViewDTO->setModelClass($this->modelClass);
        $manager    = $this->getManagerInstance();
        $result     = $manager->processDetail($detailViewDTO);
        if($result === false)
        {
            throw new ForbiddenHttpException(\Yii::t('yii','You are not authorized to perform this action.'));
        }
        $this->controller->getView()->attachBehavior('detail', ['class' => DetailBehavior::className()]);
        $view               = 'view';
        if($this->viewFile != null)
        {
            $view = $this->viewFile;
        }
        if(UsniAdaptor::app()->request->isAjax)
        {
            $detailViewDTO->setModalDisplay(true);
            return $this->controller->renderPartial($view, ['detailViewDTO' => $detailViewDTO]);
        }
        else
        {
            $detailViewDTO->setModalDisplay(false);
            return $this->controller->render($view, ['detailViewDTO' => $detailViewDTO]);
        }
    }
}