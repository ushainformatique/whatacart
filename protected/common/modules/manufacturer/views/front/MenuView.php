<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\manufacturer\views\front;

use usni\library\views\UiView;
use usni\UsniAdaptor;
use common\modules\manufacturer\models\Manufacturer;
use usni\library\components\UiHtml;
/**
 * MenuView class file
 * @package common\modules\manufacturer\views\front
 */
class MenuView extends UiView
{
    /**
     * Selected Manufacturer
     * @var string 
     */
    public $selectedName;

    /**
     * @inheritdoc
     */
    protected function renderContent()
    {
        $tableName  = Manufacturer::tableName();
        $query      = (new \yii\db\Query());
        $records     = $query->select('*')->from($tableName)->all();
        $content    = null; 
        foreach($records as $record)
        {
            if($this->selectedName == $record['name'])
            {
                $class   = 'list-group-item active';
            }
            else
            {
                $class   = 'list-group-item';
            }
            $url     = UsniAdaptor::createUrl('manufacturer/site/list', ['manufacturerId' => $record['id']]);
            $content .= UiHtml::a($record['name'], $url, ['class' => $class]);
        }
        return UiHtml::tag('div', $content, ['class' => 'list-group']);
    }
}
?>