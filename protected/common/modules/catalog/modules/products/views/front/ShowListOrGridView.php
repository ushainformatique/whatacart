<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace products\views\front;

use usni\library\views\UiView;
use usni\UsniAdaptor;
use yii\web\View;
use frontend\utils\FrontUtil;
/**
 * ShowListOrGridView class file.
 * @package products\views\front
 */
class ShowListOrGridView extends UiView
{
    /**
     * Store pjax container id.
     * @var string
     */
    protected $pjaxId;

    /**
     * Class constructor.
     * @param string $pjaxId
     */
    public function __construct($pjaxId)
    {
        $this->pjaxId   = $pjaxId;
    }

    /**
     * Render content to show list/grid.
     * @return string
     */
    protected function renderContent()
    {
        $theme      = FrontUtil::getThemeName();
        $filePath   = UsniAdaptor::getAlias('@themes/' . $theme . '/views/productCategories/_listorgrid.php');
        return $this->getView()->renderPhpFile($filePath);
    }

    /**
     * Registers script for the list product.
     * @return void
     */
    protected function registerScripts()
    {
        $script     = " $('#list-view').on('click', function(){
                                $('#content .row .product-layout').attr('class', 'product-layout product-list col-xs-12');
                                localStorage.setItem('display', 'list');
                        });
                        $('#grid-view').on('click', function(){
                                cols = $('#column-right, #column-left').length;
                                if (cols == 2) {
                                    $('#content .product-layout').attr('class', 'product-layout product-grid col-lg-6 col-md-6 col-sm-12 col-xs-12');
                                } else if (cols == 1) {
                                    $('#content .product-layout').attr('class', 'product-layout product-grid col-lg-4 col-md-4 col-sm-6 col-xs-12');
                                } else {
                                    $('#content .product-layout').attr('class', 'product-layout product-grid col-lg-3 col-md-3 col-sm-6 col-xs-12');
                                }
                                localStorage.setItem('display', 'grid');
                        });
                        if (localStorage.getItem('display') == 'list') {
                            $('#list-view').trigger('click');
                        } else {
                            $('#grid-view').trigger('click');
                        }
                       ";
        $this->getView()->registerJs($script, View::POS_END);
    }
}
