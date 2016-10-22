<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace customer\components;

use usni\UsniAdaptor;
/**
 * AccountBreadcrumb class file.
 * @package customer\components
 */
class AccountBreadcrumb extends \frontend\components\Breadcrumb
{
    /**
     * Get breadcrumb items.
     * @return string
     */
    public function getBreadcrumbLinks()
    {
        $breadcrumbData = [];
        $myAccount  = UsniAdaptor::t('customer', 'My Account');
        if($this->page != null)
        {
            $breadcrumbData[] = ['label' => $myAccount, 'url' => UsniAdaptor::createUrl('customer/site/my-account')];
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