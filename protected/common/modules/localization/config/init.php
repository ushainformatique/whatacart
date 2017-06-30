<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */


return [
        'localization' => [
                            'class' => 'common\modules\localization\Module', 
                            'modules'       => [
                                                    'city'     => [
                                                                    'class' => 'common\modules\localization\modules\city\Module'
                                                                  ],
                                                    'country'  => [
                                                                    'class' => 'common\modules\localization\modules\country\Module'
                                                                  ],
                                                    'currency' => [
                                                                    'class' => 'common\modules\localization\modules\currency\Module'
                                                                  ],
                                                    'state'    => [
                                                                    'class' => 'common\modules\localization\modules\state\Module'
                                                                  ],
                                                    'lengthclass' => [
                                                                       'class' => 'common\modules\localization\modules\lengthclass\Module'
                                                                     ],
                                                    'weightclass' => [
                                                                       'class' => 'common\modules\localization\modules\weightclass\Module'
                                                                     ],
                                                    'stockstatus' => [
                                                                       'class' => 'common\modules\localization\modules\stockstatus\Module'
                                                                     ],
                                                    'tax'         => [
                                                                       'class' => 'taxes\Module'
                                                                     ],
                                                    'orderstatus' => [
                                                                       'class' => 'common\modules\localization\modules\orderstatus\Module'
                                                                     ],
                                               ]
                          ]
      ];