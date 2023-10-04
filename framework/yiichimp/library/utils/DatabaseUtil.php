<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\utils;

use usni\UsniAdaptor;
use yii\db\Exception;
/**
 * DatabaseUtil class file.
 * 
 * @package usni\library\utils
 */
class DatabaseUtil
{
    /**
     * Removes all rows from the specified table and resets its primary key sequence, if any.
     * @param string $tableName the table name
     * @see QueryBuilder::truncateTable
     */
    public static function truncateTable($tableName)
    {
        $db = UsniAdaptor::db();
        $schema = $db->getSchema();
        if (($table = $schema->getTableSchema($tableName)) !== null)
        {
            $db->createCommand()->delete($table->fullName)->execute();
            if ($table->sequenceName !== null) 
            {
                $db->createCommand()->resetSequence($table->fullName, 1)->execute();
            }
        }
        else
        {
            throw new Exception("Table '$tableName' does not exist.");
        }
    }

    /**
     * Truncates all tables in the specified schema.
     * @param string $schema the schema name. Defaults to empty string, meaning the default database schema.
     * @see truncateTable
     */
    public static function truncateTables($name = '')
    {
        $db         = UsniAdaptor::db();
        $schema     = $db->getSchema();
        $schema->refresh();
        $tableNames = $schema->getTableNames($name);
        UsniAdaptor::db()->createCommand('SET FOREIGN_KEY_CHECKS = 0;')->execute();
        foreach ($tableNames as $tableName)
        {
            self::truncateTable($tableName);
        }
        UsniAdaptor::db()->createCommand('SET FOREIGN_KEY_CHECKS = 1;')->execute();
    }

    /**
     * Remove tables from db.
     * @return void
     */
    public static function removeTablesFromDatabase()
    {
        $results = UsniAdaptor::db()->getSchema()->getTableNames();
        if (!empty($results))
        {
            UsniAdaptor::db()->createCommand('SET FOREIGN_KEY_CHECKS = 0;')->execute();
            foreach ($results as $row)
            {
                UsniAdaptor::db()->createCommand()->dropTable($row)->execute();
            }
            UsniAdaptor::db()->getSchema()->refresh();
            UsniAdaptor::db()->createCommand('SET FOREIGN_KEY_CHECKS = 1;')->execute();
        }
    }

    /**
     * Get the date format for the database in Unicode format.
     * http://www.unicode.org/reports/tr35/#Date_Format_Patterns
     * @return string
     */
    public static function getDateFormat()
    {
        return 'yyyy-MM-dd';
    }

    /**
     * Get the datetime format for the database in Unicode format.
     * http://www.unicode.org/reports/tr35/#Date_Format_Patterns
     * @return string
     */
    public static function getDateTimeFormat()
    {
        return 'yyyy-MM-dd HH:mm:ss';
    }

    /**
     * Get version number of database
     * @param string $dbHost
     * @param string $dbUsername
     * @param string $dbPassword
     * @param string $dbPort
     * @throws NotSupportedException
     */
    public static function getDatabaseVersion($dbHost, $dbUsername, $dbPassword, $dbPort)
    {
        $dsn = 'mysql:host=' . $dbHost . ';port=' . $dbPort . ';';
        try
        {
            $dbh    = new \PDO($dsn, $dbUsername, $dbPassword);
            $stmt   = $dbh->prepare('SELECT VERSION()');
            $stmt->execute();
            if($stmt->rowCount() == 1)
            {
                $obj = $stmt->fetch();
                return $obj[0];
            }
            $dbh = null;
        }
        catch (\PDOException $e)
        {
            return array($e->getCode(), $e->getMessage());
        }
        return false;
    }

    /**
     * Check if database is in strict mode
     * @param string $dbHost
     * @param string $dbUsername
     * @param string $dbPassword
     * @param string $$dbPort
     * @throws NotSupportedException
     * @return boolean
     */
    public static function isDatabaseStrictMode($dbHost, $dbUsername, $dbPassword, $dbPort)
    {
        $dsn = 'mysql:host=' . $dbHost . ';port=' . $dbPort . ';';
        try
        {
            $dbh    = new \PDO($dsn, $dbUsername, $dbPassword);
            $stmt   = $dbh->prepare('SELECT @sql_mode;');
            $stmt->execute();
            if($stmt->rowCount() == 1)
            {
                $row = $stmt->fetch();
                if (strstr($row[0], 'STRICT_TRANS_TABLES') !== false)
                {
                    $isStrict = true;
                }
                else
                {
                    $isStrict = false;
                }
                return $isStrict;
            }
            $dbh = null;
        }
        catch (\PDOException $e)
        {
            return array($e->getCode(), $e->getMessage());
        }
        return false;
    }

    /**
     * Check if can connect to database or not.
     * @param string $dbHost
     * @param string $dbUsername
     * @param string $dbPassword
     * @param string $$dbPort
     * @throws NotSupportedException
     * @return mixed $error
     */
    public static function checkDbConnection($dbHost, $dbUsername, $dbPassword, $dbPort)
    {
        $errorNumber    = 0;
        $errorString    = '';
        $timeout        = 2;
        $connection     = @fsockopen($dbHost, $dbPort, $errorNumber, $errorString, $timeout);
        if ($connection !== false)
        {
            fclose($connection);
            return true;
        }
        return array($errorNumber, $errorString);
    }

    /**
     * Check if database exist or not.
     * @param string $dbHost
     * @param string $dbUsername
     * @param string $dbPassword
     * @param string $$dbPort
     * @param string $databaseName
     * @throws NotSupportedException
     * @returns true/false for if the named database exists.
     */
    public static function checkDatabaseExists($dbHost, $dbUsername, $dbPassword, $dbPort, $databaseName)
    {
        $dsn = 'mysql:host=' . $dbHost . ';port=' . $dbPort . ';dbname=' . $databaseName . ';';
        try
        {
            $dbh    = self::getPDOInstance($dsn, $dbUsername, $dbPassword);
            $dbh = null;
            return true;
        }
        catch (\PDOException $e)
        {
            return array($e->getCode(), $e->getMessage());
        }
    }

    /**
     * Check if database user exist
     * @param string $dbHost
     * @param string $dbAdminUsername
     * @param string $dbAdminPassword
     * @param string $$dbPort
     * @param string $dbUserName
     * @throws NotSupportedException
     * @returns true/false for if the named database user exists.
     */
    public static function checkDatabaseUserExists($dbHost, $dbAdminUsername, $dbAdminPassword, $dbPort, $dbUserName)
    {
        $dsn = 'mysql:host=' . $dbHost . ';port=' . $dbPort . ';';
        try
        {
            $dbh    = self::getPDOInstance($dsn, $dbAdminUsername, $dbAdminPassword);
            $stmt   = $dbh->prepare('SELECT User FROM mysql.user WHERE User=:un LIMIT 1');
            $stmt->bindParam(':un', $dbUserName);
            $stmt->execute();
            if($stmt->rowCount() > 0)
            {
                return true;
            }
            $dbh = null;
        }
        catch (\PDOException $e)
        {
            return array($e->getCode(), $e->getMessage());
        }
        return false;
    }

    /**
     * Creates the named database, dropping it first if it already exists.
     * @param string $dbHost
     * @param string $dbAdminUsername
     * @param string $dbAdminPassword
     * @param string $dbPort
     * @param string $databaseName
     * @throws NotSupportedException
     * @return boolean|string error
     */
    public static function createDatabase($dbHost, $dbAdminUsername, $dbAdminPassword, $dbPort, $databaseName)
    {
        $dsn = 'mysql:host=' . $dbHost . ';port=' . $dbPort . ';';
        try
        {
            $dbh    = self::getPDOInstance($dsn, $dbAdminUsername, $dbAdminPassword);
            $dbh->exec("DROP DATABASE IF EXISTS `$databaseName`;");
            $dbh->exec("CREATE DATABASE `$databaseName`;");
            $dbh = null;
            return true;
        }
        catch (\PDOException $e)
        {
            return array($e->getCode(), $e->getMessage());
        }
    }

    /**
     * Creates the named database user, dropping it first if it already exists.
     * Grants the user full access on the given database.
     * @param string $databaseType
     * @param string $dbHost
     * @param string $dbAdminUsername
     * @param string $dbAdminPassword
     * @param string $dbPort
     * @param string $databaseName
     * @param string $dbUsername
     * @param string $dbPassword
     * @throws NotSupportedException
     * @return boolean|string error
     */
    public static function createDatabaseUser($dbHost, $dbAdminUsername, $dbAdminPassword, $dbPort, $databaseName, $dbUsername, $dbPassword)
    {
        $dsn = 'mysql:host=' . $dbHost . ';port=' . $dbPort . ';dbname=' . $databaseName . ';';
        try
        {
            $dbh    = self::getPDOInstance($dsn, $dbAdminUsername, $dbAdminPassword);
            $dbh->exec("CREATE USER '$dbUsername'@'$dbHost' IDENTIFIED BY '$dbPassword';");
            self::grantDatabaseUserPreviliges($dbHost, $dbAdminUsername, $dbAdminPassword, $dbPort, $databaseName, $dbUsername, $dbPassword);
            $dbh = null;
            return true;
        }
        catch (\PDOException $e)
        {
            return array($e->getCode(), $e->getMessage());
        }
    }

    /**
     * Grants the user full access on the given database.
     * @param string $databaseType
     * @param string $dbHost
     * @param string $dbAdminUsername
     * @param string $dbAdminPassword
     * @param string $dbPort
     * @param string $databaseName
     * @param string $dbUsername
     * @param string $dbPassword
     * @throws NotSupportedException
     * @return boolean|string error
     */
    public static function grantDatabaseUserPreviliges($dbHost, $dbAdminUsername, $dbAdminPassword, $dbPort, $databaseName, $dbUsername, $dbPassword)
    {
        $dsn = 'mysql:host=' . $dbHost . ';port=' . $dbPort . ';dbname=' . $databaseName . ';';
        try
        {
            $dbh    = self::getPDOInstance($dsn, $dbAdminUsername, $dbAdminPassword);
            $dbh->exec("GRANT ALL ON `$databaseName`.* TO '$dbUsername'@'$dbHost';
                        FLUSH PRIVILEGES;");
            $dbh = null;
            return true;
        }
        catch (\PDOException $e)
        {
            return array($e->getCode(), $e->getMessage());
        }
    }

    /**
     * Get default port for database.
     * @return int
     */
    public static function getDatabaseDefaultPort()
    {
        return 3306;
    }

    /**
     * Baackup database schema and stored procedures.
     * @param string $host
     * @param string $username
     * @param string $password
     * @param int $port
     * @param string $databaseName
     * @param string $backupFilePath
     * @throws NotSupportedException
     * @return boolean
     */
    public static function backupDatabase($host, $username, $password, $port, $databaseName, $backupFilePath)
    {
        $result = exec("mysqldump --host=$host --user=$username --password=$password --port=$port --routines --add-drop-database $databaseName > $backupFilePath", $output, $returnVal);

        if ($returnVal !== 0)
        {
            return false;
        }
        else
        {
            return true;
        }
    }

    /**
     * Restore database.
     * @param string $host
     * @param string $username
     * @param string $password
     * @param int $port
     * @param string $databaseName
     * @param string $restoreFilePath
     * @throws NotSupportedException
     * @return boolean
     */
    public static function restoreDatabase($host, $username, $password, $port, $databaseName, $restoreFilePath)
    {
        $result = exec("mysql --host=$host --user=$username --password=$password --port=$port $databaseName < $restoreFilePath", $output, $returnVal);
        if ($returnVal !== 0)
        {
            return false;
        }
        else
        {
            return true;
        }
        return $result;
    }

    /**
     * Drops the named database.
     * @param string $host
     * @param string $dbAdminUsername
     * @param string $dbAdminPassword
     * @param string $dbPort
     * @param string $databaseName
     * @throws NotSupportedException
     * @return boolean|string error
     */
    public static function dropDatabase($dbHost, $dbAdminUsername, $dbAdminPassword, $dbPort, $databaseName)
    {
        $dsn = 'mysql:host=' . $dbHost . ';port=' . $dbPort . ';';
        try
        {
            $dbh    = self::getPDOInstance($dsn, $dbAdminUsername, $dbAdminPassword);
            $dbh->exec("DROP DATABASE IF EXISTS `$databaseName`;");
            $dbh = null;
            return true;
        }
        catch (\PDOException $e)
        {
            return array($e->getCode(), $e->getMessage());
        }
    }

    /**
     * Drops the named user.
     * @param string $dbHost
     * @param string $dbAdminUsername
     * @param string $dbAdminPassword
     * @param string $dbPort
     * @param string $username
     * @throws NotSupportedException
     * @return boolean|string error
     */
    public static function dropDatabaseUser($dbHost, $dbAdminUsername, $dbAdminPassword, $dbPort, $username)
    {
        $dsn = 'mysql:host=' . $dbHost . ';port=' . $dbPort . ';';
        try
        {
            $dbh    = self::getPDOInstance($dsn, $dbAdminUsername, $dbAdminPassword);
            $dbh->exec("DROP USER '$username'@'$dbHost';");
            $dbh = null;
            return true;
        }
        catch (\PDOException $e)
        {
            return array($e->getCode(), $e->getMessage());
        }
    }

    /**
     * Gets PDO instance.
     * @param string $dsn
     * @param string $username
     * @param string $password
     * @return \PDO
     */
    public static function getPDOInstance($dsn, $username, $password)
    {
        $dbh    = new \PDO($dsn, $username, $password, array(\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION));
        return $dbh;
    }
    
    /**
     * Get raw sql query
     * @param Query $query
     * @return string
     */
    public static function getSqlQuery($query)
    {
        return $query->prepare(UsniAdaptor::app()->db->queryBuilder)->createCommand()->rawSql;
    }
}