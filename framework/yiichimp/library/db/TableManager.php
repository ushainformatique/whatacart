<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\db;

/**
 * TableManager contains the list of table builders for the module.
 * 
 * @package usni\library\db
 */
abstract class TableManager extends \yii\base\Component
{
    /**
     * Build module tables
     */
    public function buildTables()
    {
        $config = static::getTableBuilderConfig();
        try
        {
            foreach ($config as $class)
            {
                $instance = new $class();
                $instance->buildTable();
            }
        }
        catch (\yii\db\Exception $e)
        {
            throw $e;
        }
    }
    
    /**
     * Get complete database sql
     * @return string
     */
    public function getTablesSql()
    {
        $sqlStr   = null;
        $config = static::getTableBuilderConfig();
        try
        {
            foreach ($config as $class)
            {
                $sqls     = [];
                $instance = new $class();
                $sqls[]   = $instance->getTableSql();
                $indexSql = $instance->getIndexSql();
                if($indexSql != null)
                {
                    $sqls[]   = $indexSql;
                }
                $trSql    = $instance->getTranslatedTableSql();
                if($trSql != null)
                {
                    $sqls[]   = $trSql;
                }
                if(!empty($sqls))
                {
                    $sqlStr   .= implode(';', $sqls);
                }
            }
            return $sqlStr;
        }
        catch (\Exception $e)
        {
            throw $e;
        }
        return null;
    }
    
    /**
     * Get table builder config.
     * @return array
     */
    protected static function getTableBuilderConfig()
    {
        throw new \usni\library\exceptions\MethodNotImplementedException(__METHOD__, __CLASS__);
    }
    
    /**
     * Drop tables
     * @return void
     */
    public function dropTables()
    {
        $config = static::getTableBuilderConfig();
        foreach ($config as $class)
        {
            $instance = new $class();
            $tableName = $instance->getTableName();
            $instance->dropTableIfExists($tableName);
        }
    }
}
