<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace productCategories\traits;

use usni\UsniAdaptor;
use usni\library\components\UiHtml;
/**
 * Contains utility methods related to product category.
 * 
 * @package productCategories\traits
 */
trait ProductCategoryTrait
{
    use \usni\library\traits\TreeModelTrait;
    
    /**
     * @inheritdoc
     */
    public function descendants($parentId = 0, $isChildren = false)
    {
        $recordsData    = [];
        $tableName      = UsniAdaptor::tablePrefix() . 'product_category';
        $trTableName    = UsniAdaptor::tablePrefix() . 'product_category_translated';
        $currentStore   = UsniAdaptor::app()->storeManager->getCurrentStore();
        $language       = UsniAdaptor::app()->languageManager->getContentLanguage();
        $sql                    = "SELECT tpc.*, tpct.name, tpct.alias, tpct.metakeywords, tpct.metadescription, tpct.description
                                   FROM $tableName tpc, $trTableName tpct
                                   WHERE tpc.parent_id = :pid AND tpc.data_category_id = :dci AND tpc.id = tpct.owner_id AND tpct.language = :lang";
        $connection             = UsniAdaptor::app()->getDb();
        $params                 = [':pid' => $parentId, ':dci' => $currentStore->data_category_id, ':lang' => $language];
        $records                = $connection->createCommand($sql, $params)->queryAll();
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
            return $records;
        }
    }
    
    /**
     * @inheritdoc
     * There might be fields which are translated for that we could not use array
     */
    public function getMultiLevelSelectOptions($textFieldName,
                                               $parentId = 0,
                                               $delimiter = '-',
                                               $isDefaultPrompt = true,
                                               $shouldReturnOwnerCreatedModelsOnly = false,
                                               $valueFieldName = 'id')
    {
        $itemsArray     = [];
        if($isDefaultPrompt)
        {
            $itemsArray = ['' => UiHtml::getDefaultPrompt()];
        }
        $items   = $this->descendants($parentId, false);
        $items   = static::flattenArray($items);
        foreach($items as $item)
        {
            $row = $item['row'];
            if($shouldReturnOwnerCreatedModelsOnly)
            {
                if($this->getInstance()->$valueFieldName != $row[$valueFieldName])
                {
                    //In case of new record, created_by should be set before calling this function @see PageEditView
                    if($this->created_by == $row['created_by'])
                    {
                        $itemsArray[$row[$valueFieldName]] = str_repeat($delimiter, $row['level']) . $row[$textFieldName];
                    }
                }
            }
            else
            {
                if($this->getInstance()->$valueFieldName != $row[$valueFieldName])
                {
                    $itemsArray[$row[$valueFieldName]] = str_repeat($delimiter, $row['level']) . $row[$textFieldName];
                }
            }
        }
        return $itemsArray;
    }
}