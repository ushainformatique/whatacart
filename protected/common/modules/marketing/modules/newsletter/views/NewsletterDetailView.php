<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace newsletter\views;

use usni\library\views\UiDetailView;
use common\modules\stores\utils\StoreUtil;
use newsletter\utils\NewsletterUtil;
use usni\UsniAdaptor;
use usni\library\modules\users\models\User;
/**
 * NewsletterDetailView class file.
 * @package newsletter\views
 */
class NewsletterDetailView extends UiDetailView
{

    /**
     * @inheritdoc
     */
    public function getColumns()
    {
        return [
                   [
                       'attribute'  => 'store_id',
                       'value'      => $this->getStore()
                   ],
                   [
                       'attribute'  => 'to',
                       'value'      => $this->getToNewsletter()
                   ],
                   'subject',
                   [
                       'attribute'  => 'content',
                       'format'     => 'raw'
                   ],
               ];
    }

    /**
     * @inheritdoc
     */
    protected function renderDetailModelBrowseView()
    {
        return null;
    }
    
    /**
     * Get store.
     * @return string
     */
    protected function getStore()
    {
        $store = StoreUtil::getStoreById($this->model->store_id);
        return $store['name'];
    }
    
    /**
     * Get to newsletter
     * @return string
     */
    protected function getToNewsletter()
    {
        $toNewsletters = NewsletterUtil::getToNewsletterDropdown();
        return $toNewsletters[$this->model->to];
    }
    
    /**
     * @inheritdoc
     */
    protected function getOptionItems()
    {
        $optionItems    = parent::getOptionItems();
        $user           = UsniAdaptor::app()->user->getUserModel();
        if($user->id == User::SUPER_USER_ID)
        {
            unset($optionItems[0]);
        }        
        return $optionItems;
    }
}
?>