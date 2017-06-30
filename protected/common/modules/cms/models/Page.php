<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\cms\models;

use usni\library\db\TranslatableActiveRecord;
use usni\UsniAdaptor;
use common\modules\cms\dao\PageDAO;
/**
 * Page active record.
 * 
 * @package common\modules\cms\models
 */
class Page extends TranslatableActiveRecord
{
    use \usni\library\traits\TreeModelTrait;
    
    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        if(parent::beforeSave($insert))
        {
            $this->level = $this->getLevel();
            return true;
        }
       return false;
    }
    
    /**
     * @inheritdoc
     */
    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        $this->updateChildrensLevel();
        $this->updatePath();
    }
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
                    [['name', 'alias', 'status'],                   'required', 'except' => 'bulkedit'],
                    [['name'],                                      'unique', 'targetClass' => PageTranslated::className(), 'targetAttribute' => ['name', 'language'], 'on' => 'create'],
                    [['alias'],                                     'unique', 'targetClass' => PageTranslated::className(), 'targetAttribute' => ['alias', 'language'], 'on' => 'create'],
                    ['name',                                        'unique', 'targetClass' => PageTranslated::className(), 'targetAttribute' => ['name', 'language'], 'filter' => ['!=', 'owner_id', $this->id], 'on' => 'update'],
                    ['alias',                                       'unique', 'targetClass' => PageTranslated::className(), 'targetAttribute' => ['alias', 'language'], 'filter' => ['!=', 'owner_id', $this->id], 'on' => 'update'],
                    ['custom_url',                                              'safe'],
                    ['custom_url',                                              'url'],
                    [['status', 'parent_id'],                                   'number'],
                    [['name', 'alias'],                                         'string', 'max' => 128],
                    [['parent_id'],                                         'default', 'value' => 0],
                    [['metakeywords', 'metadescription'],                       'safe'],
                    ['alias', 'match', 'pattern' => '/^[a-zA-Z0-9_-]+$/i'],
                    [['id', 'name', 'menuitem', 'alias', 'content', 'summary', 'parent_id', 'metakeywords', 
                      'metadescription', 'level', 'path'], 'safe']
               ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        $scenario               = parent::scenarios();
        $commonAttributes       = ['name', 'menuitem', 'alias', 'content', 'summary', 'metakeywords', 'metadescription', 'status', 'custom_url', 
                                   'parent_id', 'level', 'path'];
        $scenario['create']     = $scenario['update'] = $commonAttributes;
        $scenario['bulkedit']   = ['parent_id', 'status'];
        return $scenario;
    }
    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        $labels = [
                        'id'                    => UsniAdaptor::t('application', 'Id'),
                        'name'                  => UsniAdaptor::t('application', 'Name'),
                        'alias'                 => UsniAdaptor::t('application', 'Alias'),
                        'summary'               => UsniAdaptor::t('cms', 'Summary'),
                        'content'               => UsniAdaptor::t('cms', 'Content'),
                        'menuitem'              => UsniAdaptor::t('cms', 'Menu Item'),
                        'status'                => UsniAdaptor::t('application', 'Status'),
                        'metakeywords'          => UsniAdaptor::t('application', 'Meta Keywords'),
                        'metadescription'       => UsniAdaptor::t('application', 'Meta Description'),
                        'parent_id'             => UsniAdaptor::t('application', 'Parent')
                  ];
        return parent::getTranslatedAttributeLabels($labels);
    }

    /**
     * @inheritdoc
     */
    public static function getLabel($n = 1)
    {
        return ($n == 1) ? UsniAdaptor::t('cms', 'Page') : UsniAdaptor::t('cms', 'Pages');
    }

    /**
     * Get attribute hints.
     * return array
     */
    public function attributeHints()
    {
        return array(
            'alias'   => UsniAdaptor::t('applicationhint', 'Spaces not allowed. Allowed characters [a-zA-Z0-9_-]'),
            'name'    => UsniAdaptor::t('applicationhint', 'Minimum 3 characters'),
            'summary'    => UsniAdaptor::t('cmshint', 'Summary for the page'),
            'content'    => UsniAdaptor::t('cmshint', 'Content for the page'),
            'menuitem'   => UsniAdaptor::t('cmshint', 'Menu text for the page'),
            'metakeywords'   => UsniAdaptor::t('cmshint', 'Meta keywords for the page'),
            'metadescription'   => UsniAdaptor::t('cmshint', 'Meta description for the page'),
            'parent_id'   => UsniAdaptor::t('cmshint', 'Parent for the page'),
            'status'   => UsniAdaptor::t('cmshint', 'Status for the page')
        );
    }

    /**
     * @inheritdoc
     */
    public function beforeDelete()
    {
        if(parent::beforeDelete())
        {
            UsniAdaptor::db()->createCommand()->update(self::tableName(),
                                                    ['parent_id' => 0],
                                                    'parent_id = :pid',
                                                    [':pid' => $this->id])->execute();
            return true;
        }
        return false;
    }

    /**
     * @inheritdoc
     */
    public static function getTranslatableAttributes()
    {
        return ['name', 'menuitem', 'content', 'summary', 'metakeywords', 'metadescription', 'alias'];
    }
    
    /**
     * Get descendants based on a parent.
     * @param int $parentId
     * @param int $isChildren If only childrens have to be fetched
     * @return boolean
     */
    public function descendants($parentId = 0, $isChildren = false)
    {
        $recordsData    = [];
        $language       = $this->language;
        $records        = PageDAO::getChildrens($parentId, $language);
        if(!$isChildren)
        {
            foreach($records as $record)
            {
                $hasChildren    = false;
                $childrens      = $this->descendants($record['id'], $isChildren);
                if(count($childrens) > 0)
                {
                    $hasChildren = true;
                }
                $recordsData[]  = ['row'         => $record,
                                   'hasChildren' => $hasChildren, 
                                   'children'    => $childrens];
            }
            return $recordsData;
        }
        else
        {
            foreach($records as $record)
            {
                $recordsData[]  = ['row'         => $record,
                                   'hasChildren' => false, 
                                   'children'    => []];
            }
            return $recordsData;
        }
    }
    
    /**
     * inheritdoc
     */
    public function getMultiLevelSelectOptions($textFieldName,
                                               $accessOwnedModelsOnly = false,
                                               $valueFieldName = 'id')
    {
        $childrens      = array_keys($this->getTreeRecordsInHierarchy());
        $itemsArray     = [];
        if($this->nodeList === null)
        {
            $this->nodeList  = $this->descendants(0, false);
        }
        $items   = static::flattenArray($this->nodeList);
        foreach($items as $item)
        {
            $row = $item['row'];
            if($this->$valueFieldName != $row[$valueFieldName])
            {
                if(($accessOwnedModelsOnly === true && $this->created_by == $row['created_by']) || ($accessOwnedModelsOnly === false))
                {
                    if(!in_array($row['id'], $childrens))
                    {
                        $itemsArray[$row[$valueFieldName]] = str_repeat('-', $row['level']) . $row[$textFieldName];
                    }
                }
            }
        }
        return $itemsArray;
    }
}