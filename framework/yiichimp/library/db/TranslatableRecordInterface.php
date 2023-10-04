<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\db;

/**
 * TranslatableRecordInterface would be implemented by active records having translatable
 * content.
 * 
 * @package usni\library\db
 */
interface TranslatableRecordInterface
{
    /**
     * Get translatable attributes.
     * @return array
     */
    public static function getTranslatableAttributes();
}
