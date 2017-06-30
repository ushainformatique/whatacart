<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace products\models;

use usni\library\db\TranslatableActiveRecord;
use usni\UsniAdaptor;
/**
 * Tag active record.
 * @package products\models
 */
class Tag extends TranslatableActiveRecord
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
                    ['name',        'required'],
                    ['frequency',   'number'],
                    ['name',        'string', 'max' => 128],
               ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        $labels = [
                    'id'        => UsniAdaptor::t('application', 'Id'),
                    'name'      => UsniAdaptor::t('application', 'Name'),
                    'frequency' => UsniAdaptor::t('products', 'Frequency'),
                  ];
        return parent::getTranslatedAttributeLabels($labels);
    }
    
    /**
     * @inheritdoc
     */
    public static function getTranslatableAttributes()
    {
        return ['name'];
    }
}