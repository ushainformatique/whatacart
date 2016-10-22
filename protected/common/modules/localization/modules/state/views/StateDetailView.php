<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\localization\modules\state\views;

use usni\library\views\UiDetailView;
use usni\library\utils\StatusUtil;
use usni\UsniAdaptor;
use common\modules\localization\modules\country\models\Country;
/**
 * StateDetailView class file
 * @package common\modules\localization\modules\state\views
 */
class StateDetailView extends UiDetailView
{
    /**
     * @inheritdoc
     */
    public function getColumns()
    {
        return [
                      [
                          'label'       => Country::getLabel(1),
                          'attribute'   => 'country.name'
                      ],
                      'name',
                      'code',
                      [
                          'attribute'   => 'status', 
                          'value'       => StatusUtil::renderLabel($this->model), 
                          'format'      => 'raw'
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