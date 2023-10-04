<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\traits;

use usni\UsniAdaptor;
use usni\library\utils\ArrayUtil;
/**
 * Contains utility methods related to tree/multilevel configuration.
 * 
 * @package usni\library\traits
 */
trait TreeModelTrait
{
    /**
     * List of items in format required to generate list
     * @var array 
     */
    public $nodeList;
    
    /**
     * Get children's
     * @param int $parentId
     * @return array
     */
    public function childrens($parentId = 0)
    {
        return $this->descendants($parentId, true);
    }

    /**
     * Get the item level.
     * @return integer
     */
    public function getLevel()
    {
        $parentId = $this->parent_id;
        if($parentId == 0 || $parentId == null)
        {
            return 0;
        }
        else
        {
            $modelClassName = $this->getClassName();
            $record = $modelClassName::findOne($parentId);
            return intval($record->level) + 1;
        }
    }
    
    /**
     * Flatten array
     * @param array $items
     * @return array
     */
    public static function flattenArray($items)
    {
        $data = array();
        foreach($items as $index => $item)
        {
            if($item['hasChildren'] == true)
            {
                $children   = $item['children'];
                unset($item['children']);
                $data[]     = $item;
                $data       = ArrayUtil::merge($data, static::flattenArray($children));
            }
            else
            {
                $data[]     = $item;
            }
        }
        return $data;
    }

    /**
     * Get items drop down in a tree format.
     * @param string  $textFieldName Text field name.
     * @param boolean $accessOwnedModelsOnly
     * @param string $valueFieldName
     * @return array
     */
    public function getMultiLevelSelectOptions($textFieldName,
                                               $accessOwnedModelsOnly = false,
                                               $valueFieldName = 'id')
    {
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
                    $itemsArray[$row[$valueFieldName]] = str_repeat('-', $row['level']) . $row[$textFieldName];
                }
            }
        }
        return $itemsArray;
    }

    /**
     * In case the parent is deleted, set the children parent as null.
     * @param string $tableName
     * @return void
     */
    public function setParentAsNullForChildrenOnDelete($tableName)
    {
        UsniAdaptor::db()->createCommand()->update($tableName,
                                                    ['parent_id' => 0, 'level' => $this->level],
                                                    'parent_id = :pid',
                                                    [':pid' => $this->id])->execute();
    }

    /**
     * Updates children level.
     * @return void
     */
    public function updateChildrensLevel()
    {
        $rows = $this->findAll(['parent_id' => $this->id]);
        if(!empty($rows))
        {
            foreach($rows as $row)
            {
                $row->level = $this->level + 1;
                $row->save();
                $row->updateChildrensLevel();
            }
        }
    }
    
    /**
     * Get items records in a tree format in hierarchy.
     * @param $parentId integer
     * @return array
     */
    public function getTreeRecordsInHierarchy()
    {
        $items   = $this->descendants($this->id, false);
        $items   = static::flattenArray($items);
        $rawData = [];
        foreach ($items as $item)
        {
            $rawData[$item['row']['id']] = $item['row'];
        }
        return $rawData;
    }
    
    /**
     * Get level filter
     * @return array
     */
    public function getLevelFilterDropdown()
    {
        $className  = $this->getClassName();
        $results    = $className::find()->select('level')->distinct()->asArray()->all();
        return ArrayUtil::map($results, 'level', 'level');
    }
    
    /**
     * Get parent name.
     * @return string
     */
    public function getParentName()
    {
        $class  = $this->getClassName();
        if($this->parent_id == 0)
        {
            return UsniAdaptor::t('application', '(not set)');
        }
        $record = $class::find()->where('id = :id', [':id' => $this->parent_id])->one();
        if(!empty($record))
        {
            return $record->name;
        }
        return UsniAdaptor::t('application', '(not set)');
    }
    
    /**
     * Get qualified class name. If owner is a behavior, return owner class name.
     * @return string
     */
    protected function getClassName()
    {
        return get_class($this);
    }
    
    /**
     * Update the path for the node
     * @return void
     */
    public function updatePath()
    {
        $class  = $this->getClassName();
        if($this->parent_id == 0)
        {
            $path = $this->id;
        }
        else
        {
            $row    = $class::find()->where(['id' => $this->parent_id])->asArray()->one();
            $path = $row['path'] . '/' . $this->id;
        }
        UsniAdaptor::app()->db->createCommand()->update(self::tableName(), ['path' => $path], 'id = :id', [':id' => $this->id])->execute();
    }
}