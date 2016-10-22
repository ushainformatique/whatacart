<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\manufacturer\models;

use usni\library\components\UiSecuredActiveRecord;
use usni\UsniAdaptor;
/**
 * Manufacturer active record.
 * 
 * @package common\modules\manufacturer\models
 */
class Manufacturer extends UiSecuredActiveRecord 
{
    /**
     * Upload File Instance.
     * @var string
     */
    public $uploadInstance;
    /**
     * Upload File Instance.
     * @var string
     */
    public $savedImage;

	/**
     * @inheritdoc
     */
	public function rules()
	{
		return [
                    [['name', 'status'],                        'required'],
                    ['name',                                    'unique'],
                    ['name',                                    'string', 'max'=>64],
                    ['image',                                   'string', 'max'=>255],
                    [['status'],                                'number', 'integerOnly' => true],
                    ['status', 'safe'],
                    [['uploadInstance'], 'image', 'skipOnEmpty' => true, 'extensions' => 'jpg, png, gif'],
                    [['id', 'name', 'image', 'status'],         'safe'],
               ];
	}
    
    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios['create']        = $scenarios['update'] = $scenarios['search'] = ['name', 'image', 'status'];
        $scenarios['bulkedit']      = ['status'];
        $scenarios['deleteimage']   = ['image'];
        return $scenarios;
    }

	/**
     * @inheritdoc
     */
	public function attributeLabels()
	{
		$labels = [
                     'id'       => UsniAdaptor::t('application', 'Id'),
                     'name'		=> UsniAdaptor::t('application', 'Name'),
                     'image'    => UsniAdaptor::t('application', 'Image'),
                     'status'   => UsniAdaptor::t('application', 'Status'),
                  ];
        return parent::getTranslatedAttributeLabels($labels);
	}
    
    /**
     * @inheritdoc
     */
    public static function getLabel($n = 1)
    {
        return ($n == 1) ? UsniAdaptor::t('manufacturer', 'Manufacturer') : UsniAdaptor::t('manufacturer', 'Manufacturers');
    }
}