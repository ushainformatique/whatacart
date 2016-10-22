<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace common\modules\stores\views;

use usni\library\views\UiView;
use common\managers\StoreManager;
use usni\UsniAdaptor;
use usni\library\components\UiHtml;
use usni\fontawesome\FA;
use yii\bootstrap\Dropdown;
/**
 * StoreView class file..
 *
 * @package common\modules\stores\views;
 */
class StoreView extends UiView
{
    /**
     * @inheritdoc
     */
    protected function renderContent()
    {
        $data    = StoreManager::getAllowed();
        if(count($data) > 1)
        {
            $currentStore   = UsniAdaptor::app()->storeManager->getCurrentStore();
            $headerLink     = FA::icon('shopping-basket') . "\n" .
                              UiHtml::tag('span', $currentStore->name) . "\n" .
                              FA::icon('caret-down');
            $items          = [];
            foreach($data as $key => $value)
            {
                $items[] = ['label' => $value, 'url' => '#', 'linkOptions' => ['class' => 'store-selector', 'data-store-id' => $key]];
            }
            $headerLink     = UiHtml::a($headerLink, '#', array('data-toggle' => 'dropdown', 'class' => 'dropdown-toggle'));

            $listItems      = Dropdown::widget(['items'         => $items,
                                                'options'       => ['class' => 'dropdown-menu'],
                                                'encodeLabels'  => false
                                               ]);
            $content        = $headerLink . $listItems;
            return '<li class="dropdown">' . $content . '</li>';
        }
        return null;
    }
    
    /**
     * @inheritdoc
     */
    protected function registerScripts()
    {
        $getUrl = $this->getUrl();
        $script = "$('.store-selector').click(function(){
                                                    var value = $(this).data('store-id');
                                                    $.ajax({
                                                            'type':'GET',
                                                            'url':'{$getUrl}' + '?id=' + value,
                                                            'success':function(data)
                                                                      {
                                                                      }
                                                          });
                                                    return false;
                                                 });";
        $this->getView()->registerJs($script);
    }
    
    /**
     * Get url
     * @return string
     */
    protected function getUrl()
    {
        return UsniAdaptor::createUrl('stores/default/set-store');
    }
}
?>