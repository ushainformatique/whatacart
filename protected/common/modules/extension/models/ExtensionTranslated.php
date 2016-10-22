<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\extension\models;

use usni\library\components\UiSecuredActiveRecord;
/**
 * ExtensionTranslated class file. 
 *
 * @package common\modules\extension\models
 */
class ExtensionTranslated extends UiSecuredActiveRecord
{
	/**
     * @inheritdoc
     */
    public function getExtension()
    {
        return $this->hasOne(Extension::className(), ['id' => 'owner_id']);
    }
}