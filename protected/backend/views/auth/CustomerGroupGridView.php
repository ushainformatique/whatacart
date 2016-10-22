<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace backend\views\auth;

use usni\library\modules\auth\views\GroupGridView;
use backend\components\CustomerAuthActionColumn;
/**
 * CustomerGroupGridView class file.
 * 
 * @package backend\views\auth
 */
class CustomerGroupGridView extends GroupGridView
{
    /**
     * @inheritdoc
     */
    public function __construct($config)
    {
        parent::__construct($config);
        $this->pjaxContainerId = 'groupgridview-pjax';
    }
    
    /**
     * @inheritdoc
     */
    protected function resolveActionColumnClassName()
    {
        return CustomerAuthActionColumn::className();
    }
}
