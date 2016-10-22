<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace common\modules\manufacturer\views\front;

use common\modules\manufacturer\models\Manufacturer;
use common\modules\manufacturer\views\front\MenuView;
/**
 * ProductManufacturerView class file.
 *
 * @package common\modules\manufacturer
 */
class ProductManufacturerView extends \frontend\views\common\SearchResultsView
{
    /**
     * Manufacturer associated with the view 
     * @var array 
     */
    public $manufacturer;
    
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        if(empty($this->manufacturer))
        {
            $tableName  = Manufacturer::tableName();
            $query      = (new \yii\db\Query());
            $this->manufacturer     = $query->select('*')->from($tableName)->where('id = :id', [':id' => $this->model->manufacturerId])->one();
        }
    }
    
    /**
     * @inheritdoc
     */
    protected function getLeftColumnContent()
    {
        $record = $this->manufacturer;  
        $view   = new MenuView(['selectedName' => $record['name']]);
        return $view->render();
    }
    
    /**
     * @inheritdoc
     */
    protected function getTitle()
    {
        $record     = $this->manufacturer;
        return $record['name'];
    }
}