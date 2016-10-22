<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace customer\views\front;

use usni\UsniAdaptor;
use frontend\views\FrontPageView;
/**
 * AccountPageView class file.
 * @package customer\views\front
 */
class AccountPageView extends FrontPageView
{
    /**
     * Customer model
     * @var Customer 
     */
    public $model;
    
    /**
     * @inheritdoc
     */
    public function __construct($config = array())
    {
        if($this->model == null)
        {
            $this->model = UsniAdaptor::app()->user->getUserModel();
        }
        parent::__construct($config);
    }
    
    /**
     * @inheritdoc
     */
    protected function getLeftColumnContent()
    {
        $viewHelper         = UsniAdaptor::app()->getModule('customer')->viewHelper;
        $view               = $viewHelper->getInstance('sidebarColumnView');
        return $view->render();
    }
}
