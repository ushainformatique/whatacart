<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\web\actions;

use usni\UsniAdaptor;
/**
 * This is the standalone action for creating model.
 *
 * @package usni\library\web\actions
 */
class CreateAction extends EditAction
{
    /**
     * inheritdoc
     */
    public $scenario = 'create';
    /**
     * @var string update url to which browser would redirect after save.
     * This property must be set.
     */
    public $updateUrl;
    
    /**
     * Runs the action
     * @return string
     */
    public function run()
    {
        $model          = new $this->modelClass(['scenario' => $this->scenario]);
        $postData       = UsniAdaptor::app()->request->post();
        $formDTO        = new $this->formDTOClass();
        $formDTO->setModel($model);
        $formDTO->setPostData($postData);
        $formDTO->setScenario($this->scenario);
        //Derive manager and call the function
        $manager        = $this->getManagerInstance();
        $manager->processEdit($formDTO);
        if($formDTO->getIsTransactionSuccess())
        {
            $message = UsniAdaptor::t('applicationflash', 'Record has been saved successfully.');
            UsniAdaptor::app()->getSession()->setFlash('success', $message);
            return $this->controller->redirect([$this->updateUrl, 'id' => $formDTO->getModel()->id]);
        }
        else
        {
            if($this->viewFile == null)
            {
                return $this->controller->render('create', ['formDTO' => $formDTO]);
            }
            return $this->controller->render($this->viewFile, ['formDTO' => $formDTO]);
        }
    }
}