<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace customer\web\actions;

use customer\models\CustomerSearchForm;
/**
 * IndexAction class file.
 *
 * @package customer\web\actions
 */
class IndexAction extends \usni\library\web\actions\IndexAction
{
    /**
     * inheritdoc
     */
    public function getSearchModelClassName()
    {
        return CustomerSearchForm::className();
    }
}