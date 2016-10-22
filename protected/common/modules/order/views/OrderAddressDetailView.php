<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\order\views;

use usni\library\views\UiDetailView;
use usni\UsniAdaptor;
use common\modules\order\utils\OrderUtil;
/**
 * AddressDetailView class.
 *
 * @package common\modules\order\views
 */
class OrderAddressDetailView extends UiDetailView
{
    /**
     * @inheritdoc
     */
    public function getColumns()
    {
        return [
                   [
                       'label'      => UsniAdaptor::t('users', 'Address'),
                       'value'      => OrderUtil::getConcatenatedAddress($this->model),
                       'format'     => 'raw'
                   ],
                ];
    }

    /**
     * @inheritdoc
     */
    protected function shouldRenderTitle()
    {
        return false;
    }

    /**
     * @inheritdoc
     */
    protected static function shouldRenderCreatedAttributes()
    {
        return false;
    }

    /**
     * @inheritdoc
     */
    protected static function shouldRenderModifiedAttributes()
    {
        return false;
    }
    
    /**
     * @inheritdoc
     */
    protected function renderDetailModelBrowseView()
    {
        return null;
    }
    
    /**
     * @inheritdoc
     */
    protected function wrapView($content)
    {
        return $content;
    }
}