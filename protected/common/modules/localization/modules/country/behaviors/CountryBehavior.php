<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\localization\modules\country\behaviors;

use common\modules\localization\modules\country\models\CountryTranslated;
use usni\library\utils\ArrayUtil;
/**
 * Implement common methods related to country
 *
 * @package common\modules\localization\modules\country\behaviors
 */
class CountryBehavior extends \yii\base\Behavior
{
    /**
     * Get country dropdown data.
     * @return array
     */
    public function getCountryDropdownData()
    {
        $country = CountryTranslated::find()->where('language = :lang', [':lang' => $this->owner->language])->asArray()->all();
        return ArrayUtil::map($country, 'owner_id', 'name');
    }
}
