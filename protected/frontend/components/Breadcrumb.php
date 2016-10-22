<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace frontend\components;

use usni\UsniAdaptor;
/**
 * Breadcrumb class file.
 *
 * @package frontend\components
 */
class Breadcrumb extends \yii\base\Component
{
    /**
     * Page for which breadcrumb has to be displayed
     * @var string 
     */
    public $page;
    
    /**
     * Get breadcrumb items.
     * @return string
     */
    public function getBreadcrumbLinks()
    {
        $breadcrumbData = [];
        if($this->page != null)
        {
            $breadcrumbData[] = ['label' => $this->page];
        }
        else
        {
            $breadcrumbData[] = ['label' => UsniAdaptor::t('application', '(not set)')];
        }
        return $breadcrumbData;
    }
}
?>