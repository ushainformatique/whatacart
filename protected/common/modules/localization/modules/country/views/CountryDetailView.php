<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\localization\modules\country\views;

use usni\library\views\UiDetailView;
use usni\library\utils\StatusUtil;
use usni\UsniAdaptor;
/**
 * CountryDetailView class file
 * @package common\modules\localization\modules\country\views
 */
class CountryDetailView extends UiDetailView
{
    /**
     * @inheritdoc
     */
    public function getColumns()
    {
        return  [
                    'name',
                    'iso_code_2',
                    'iso_code_3',
                    'address_format',
                    [
                        'attribute' => 'postcode_required',
                        'value'     => self::getPostcodeRequiredLabel($this->model)
                    ],
                    [
                        'attribute' => 'status',
                        'value'     => StatusUtil::renderLabel($this->model),
                        'format'    => 'raw'
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
    
    /**
     * Gets label for the status.
     * @param string $data ActiveRecord of the model.
     * @return string
     */
    public static function getPostcodeRequiredLabel($data)
    {
        if ($data->postcode_required == 0)
        {
            return UsniAdaptor::t('application', 'No');
        }
        elseif ($data->postcode_required == 1)
        {
            return UsniAdaptor::t('application', 'Yes');
        }
    }
}
?>