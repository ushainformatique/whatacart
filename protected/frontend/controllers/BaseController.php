<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace frontend\controllers;

use usni\library\filters\MaintenanceFilter;
/**
 * BaseController class file. Every site controller should extend from it.
 *
 * @package frontend\controllers
 */
class BaseController extends \usni\library\web\Controller
{
    /**
     * Get actions.
     * @return array
     */
    public function actions()
    {
        return array(
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        );
    }
    
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'maintenance' => [
                'class' => MaintenanceFilter::className()
            ],
        ];
    }
}
