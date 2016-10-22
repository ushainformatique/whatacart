<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
use usni\library\components\UiBaseActiveRecord;

return [
            'cms' => [
                        'class' => 'common\modules\cms\Module', 
                        'isCoreModule' => true,
                        'status'        => UiBaseActiveRecord::STATUS_ACTIVE,
                        'canBeDisabled' => false
                      ]
        ];
?>

