<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
use usni\library\components\UiBaseActiveRecord;
return [
            'marketing' => [
                            'class' => 'common\modules\marketing\Module', 
                            'isCoreModule' => false,
                            'status'        => UiBaseActiveRecord::STATUS_ACTIVE,
                            'canBeDisabled' => true,
                            'modules'       => [
                                                  'newsletter' =>       [
                                                                            'class' => 'newsletter\Module',
                                                                            'isCoreModule'  => false,
                                                                            'status'        => UiBaseActiveRecord::STATUS_ACTIVE,
                                                                            'canBeDisabled' => true,
                                                                        ],
                                               ]
                          ]
      ];
?>