<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */

use usni\library\components\UiBaseActiveRecord;

return [
        'localization' => [
                            'class' => 'common\modules\localization\Module', 
                            'isCoreModule' => true,
                            'status'        => UiBaseActiveRecord::STATUS_ACTIVE,
                            'canBeDisabled' => false,
                            'modules'       => [
                                                    'language' => [
                                                                    'class' => 'common\modules\localization\modules\language\Module', 
                                                                    'isCoreModule' => true,
                                                                    'status'        => UiBaseActiveRecord::STATUS_ACTIVE,
                                                                    'canBeDisabled' => false
                                                                  ],
                                                    'city'     => [
                                                                    'class' => 'common\modules\localization\modules\city\Module', 
                                                                    'isCoreModule' => true,
                                                                    'status'        => UiBaseActiveRecord::STATUS_ACTIVE,
                                                                    'canBeDisabled' => false
                                                                  ],
                                                    'country'  => [
                                                                    'class' => 'common\modules\localization\modules\country\Module', 
                                                                    'isCoreModule' => true,
                                                                    'status'        => UiBaseActiveRecord::STATUS_ACTIVE,
                                                                    'canBeDisabled' => false
                                                                  ],
                                                    'currency' => [
                                                                    'class' => 'common\modules\localization\modules\currency\Module', 
                                                                    'isCoreModule' => true,
                                                                    'status'        => UiBaseActiveRecord::STATUS_ACTIVE,
                                                                    'canBeDisabled' => false
                                                                  ],
                                                    'state'    => [
                                                                    'class' => 'common\modules\localization\modules\state\Module', 
                                                                    'isCoreModule' => true,
                                                                    'status'        => UiBaseActiveRecord::STATUS_ACTIVE,
                                                                    'canBeDisabled' => false
                                                                  ],
                                                    'lengthclass' => [
                                                                       'class' => 'common\modules\localization\modules\lengthclass\Module', 
                                                                       'isCoreModule' => true,
                                                                       'status'        => UiBaseActiveRecord::STATUS_ACTIVE,
                                                                       'canBeDisabled' => false
                                                                     ],
                                                    'weightclass' => [
                                                                       'class' => 'common\modules\localization\modules\weightclass\Module', 
                                                                       'isCoreModule' => true,
                                                                       'status'        => UiBaseActiveRecord::STATUS_ACTIVE,
                                                                       'canBeDisabled' => false
                                                                     ],
                                                    'stockstatus' => [
                                                                       'class' => 'common\modules\localization\modules\stockstatus\Module', 
                                                                       'isCoreModule' => false,
                                                                       'status'        => UiBaseActiveRecord::STATUS_ACTIVE,
                                                                       'canBeDisabled' => false
                                                                     ],
                                                    'tax'         => [
                                                                       'class' => 'taxes\Module', 
                                                                       'isCoreModule' => false,
                                                                       'status'        => UiBaseActiveRecord::STATUS_ACTIVE,
                                                                       'canBeDisabled' => false
                                                                     ],
                                                    'orderstatus' => [
                                                                       'class' => 'common\modules\localization\modules\orderstatus\Module', 
                                                                       'isCoreModule' => true,
                                                                       'status'        => UiBaseActiveRecord::STATUS_ACTIVE,
                                                                       'canBeDisabled' => false
                                                                     ],
                                               ]
                          ]
      ];
?>