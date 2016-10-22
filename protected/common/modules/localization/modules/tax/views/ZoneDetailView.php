<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace taxes\views;

use usni\library\views\UiDetailView;
use usni\UsniAdaptor;
use taxes\utils\TaxUtil;
/**
 * ZoneDetailView class file
 * @package taxes\views
 */
class ZoneDetailView extends UiDetailView
{
    /**
     * @inheritdoc
     */
    public function getColumns()
    {
        return [
                       'name',
                       'description',
                       [
                           'label'      => UsniAdaptor::t('country', 'Country'),
                           'value'      => TaxUtil::getZoneCountry($this->model)
                       ],
                       [
                           'label'      => UsniAdaptor::t('state', 'State'),
                           'value'      => TaxUtil::getZoneState($this->model)
                       ],
                       [
                           'label'      => UsniAdaptor::t('tax', 'Zip'),
                           'value'      => TaxUtil::getZip($this->model)
                       ]
               ];
    }

    /**
     * @inheritdoc
     */
    protected function getTitle()
    {
        return $this->model->name;
    }
    
    /**
     * Gets delete button url.
     *
     * @return string
     */
    protected function getDeleteUrl()
    {
        return UsniAdaptor::createUrl('localization/' . $this->getModule() . '/' . $this->controller->id . '/delete', ['id' => $this->model->id]);
    }

    /**
     * Gets edit button url.
     *
     * @return string
     */
    protected function getEditUrl()
    {
        return UsniAdaptor::createUrl('localization/' . $this->getModule() . '/' . $this->controller->id . '/update', ['id' => $this->model->id]);
    }
}
?>