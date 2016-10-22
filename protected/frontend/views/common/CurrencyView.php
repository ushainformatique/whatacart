<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace frontend\views\common;

use usni\library\views\UiView;
use usni\library\components\UiHtml;
use common\components\CurrencyManager;
use usni\UsniAdaptor;
use usni\fontawesome\FA;
use yii\bootstrap\Dropdown;
/**
 * CurrencyView class file.
 *
 * @package frontend\views\commmon
 */
class CurrencyView extends UiView
{
    /**
     * @inheritdoc
     */
    protected function renderContent()
    {
        $data    = CurrencyManager::getList();
        if(count($data) > 1)
        {
            $selection      = UsniAdaptor::app()->currencyManager->getDisplayCurrency();
            $headerLink     = UiHtml::tag('span', $selection) . "\n" .
                              FA::icon('caret-down');
            $items          = [];
            foreach($data as $key => $value)
            {
                $items[] = ['label' => $value, 'url' => '#', 'linkOptions' => ['class' => 'currency-selector', 'data-currency-id' => $key]];
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
        $url    = UsniAdaptor::app()->request->getUrl();
        $getUrl = UsniAdaptor::createUrl('customer/site/set-currency');
        $script = "$('.currency-selector').click(function(){
                                                    var value = $(this).data('currency-id');
                                                    $.ajax({
                                                            'type':'GET',
                                                            'url':'{$getUrl}' + '?currency=' + value,
                                                            'success':function(data)
                                                                      {
                                                                          window.location.href = '{$url}';
                                                                      }
                                                          });
                                                 });";
        $this->getView()->registerJs($script);
    }
}