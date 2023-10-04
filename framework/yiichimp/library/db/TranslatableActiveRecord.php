<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\db;

use usni\library\db\ActiveRecord;
use usni\UsniAdaptor;
/**
 * Base active record class for the model that needs translation.
 * 
 * @package usni\library\db
 */
abstract class TranslatableActiveRecord extends ActiveRecord implements TranslatableRecordInterface
{
    use \usni\library\traits\TranslationTrait;
    
    /**
     * @inheritdoc
     */
    public static function getTranslatableAttributes()
    {
        return [];
    }
    
    /**
     * Get record by name.
     * @param string $name
     * @param string $language
     * @return Model
     */
    public static function findByName($name, $language = null)
    {
        $class          = get_called_class();
        $activeQuery    = $class::find();
        if($language == null)
        {
            $language = UsniAdaptor::app()->language;
        }
        if(in_array('name', static::getTranslatableAttributes()))
        {
            $activeQuery = $activeQuery->joinWith('translations', true, 'INNER JOIN');
            return $activeQuery->where('name = :name AND language = :language', [':name' => $name, ':language' => $language])->one();
        }
        else
        {
            return $activeQuery->where('name = :name', [':name' => $name])->one();
        }
    }
}