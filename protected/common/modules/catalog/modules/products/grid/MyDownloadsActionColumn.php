<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace products\grid;

use usni\UsniAdaptor;
use usni\fontawesome\FA;
use usni\library\utils\Html;
use usni\library\grid\ActionColumn;
/**
 * MyDownloadsActionColumn class file.
 *
 * @package products\components\grid
 */
class MyDownloadsActionColumn extends ActionColumn
{
    /**
     * Initializes the default button rendering callbacks
     */
    protected function initDefaultButtons()
    {
        if (!isset($this->buttons['download']))
        {
            $this->buttons['download'] = array($this, 'renderDownloadActionLink');
        }
    }
    
    /**
     * @inheritdoc
     */
    protected function renderDownloadActionLink($url, $model, $key)
    {
        if($model['download_option'] == 'download')
        {
            $url        = UsniAdaptor::createUrl('customer/site/download', ['id' => $model['id'], 'orderId' => $model['order_id']]);
            $icon       = FA::icon('cloud-download');
            $options    = [
                            'title' => UsniAdaptor::t('products', 'Download'),
                            'data-pjax' => '0',
                            'id'        => 'download-' . $model['id'],
                            'class'     => 'download-product'
                          ];
            return Html::a($icon, $url, $options);
        }
    }
}