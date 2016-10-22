<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace console\components;

/**
 * CurrencyManager class file.
 * @package console\components
 */
class CurrencyManager extends \common\components\CurrencyManager
{
    /**
     * @inheritdoc
     */
    public function getDisplayCurrency()
    {
        return 'INR';
    }
}
?>