<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace products\widgets;

use common\utils\ApplicationUtil;
use usni\UsniAdaptor;
/**
 * TopNavCompareProducts renders compare list in top nav in front end
 *
 * @package products\widgets
 */
class TopNavCompareProducts extends \yii\bootstrap\Widget
{
    /**
     * inheritdoc
     */
    public function run()
    {
        $compareProducts   = ApplicationUtil::getCompareProducts();
        $count             = $compareProducts->getCount();
        $content           = UsniAdaptor::t('products', 'Compare');
        if($count > 0)
        {
            return $content . ' (' . $count . ')';
        }
        return $content;
    }
}
