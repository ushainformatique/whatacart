<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace products\controllers;

use products\business\ImageManager;
use yii\web\ForbiddenHttpException;
use yii\filters\AccessControl;
/**
 * ProductImageController class file.
 * 
 * @package products\controllers
 */
class ProductImageController extends \usni\library\web\Controller
{
    /**
     * inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['delete'],
                        'roles' => ['product.delete'],
                    ]
                ],
            ],
        ];
    }
    
    /**
     * Process delete.
     * @param int $id
     * @throws ForbiddenHttpException
     */
    public function actionDelete($id)
    {
        $result = ImageManager::getInstance()->processDeleteImage($id);
        if($result == false)
        {
            throw new ForbiddenHttpException(\Yii::t('yii','You are not authorized to perform this action.'));
        }
    }
}