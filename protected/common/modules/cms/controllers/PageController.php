<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\cms\controllers;

use common\modules\cms\controllers\CmsController;
use common\modules\cms\models\Page;
/**
 * PageController class file
 * @package common\modules\cms\controllers
 */
class PageController extends CmsController
{    
    /**
     * @inheritdoc
     */
    protected function resolveModelClassName()
    {
        return Page::className();
    }

    /**
     * @inheritdoc
     */
    protected static function getLabel($n = 1)
    {
        return Page::getLabel($n);
    }
}
?>