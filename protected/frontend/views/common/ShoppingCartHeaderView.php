<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace frontend\views\common;

use usni\library\views\UiView;
use usni\library\components\UiHtml;
use cart\views\HeaderCartSubView;
/**
 * ShoppingCartHeaderView class file.
 * @package frontend\views\commmon
 */
class ShoppingCartHeaderView extends UiView
{
    /**
     * @inheritdoc
     */
    protected function renderContent()
    {
        $subView      = new HeaderCartSubView();
        $innerContent = $subView->render();
        return UiHtml::tag('div', $innerContent, ['id' => 'cart', 'class' => 'btn-group btn-block']);
    }
    
    /**
     * @inheritdoc
     */
    protected function registerScripts()
    {
        $script = "$('body').on('click', '#cart > .heading a', function() {
                    $('#cart').addClass('active');

                    $('body').on('mouseleave', '#cart', function() {
                        $(this).removeClass('active');
                    });
                });";
        $this->getView()->registerJs($script);
    }
}
