<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace console\controllers;

use usni\library\utils\ArrayUtil;
use Yii;
use yii\console\Exception;
use yii\helpers\FileHelper;
/**
 * Extends message controller as controller namespace has been changed
 * @package console\controllers
 */
class MessageController extends \yii\console\controllers\MessageController
{
    /**
     * @ihdoc
     * Override so that we can merge the source files from application and framework to extract the messages.
     * @see line 73 and 74
     */
    public function actionExtract($configFile)
    {
        $configFile = Yii::getAlias($configFile);
        if (!is_file($configFile))
        {
            throw new Exception("The configuration file does not exist: $configFile");
        }

        $config = array_merge([
            'translator' => 'Yii::t',
            'overwrite' => false,
            'removeUnused' => false,
            'markUnused' => true,
            'sort' => false,
            'format' => 'php',
            'ignoreCategories' => [],
            ], require($configFile));

        if (!isset($config['sourcePath'], $config['languages']))
        {
            throw new Exception('The configuration file must specify "sourcePath" and "languages".');
        }
        if (!is_dir($config['sourcePath']))
        {
            throw new Exception("The source path {$config['sourcePath']} is not a valid directory.");
        }
        if (empty($config['format']) || !in_array($config['format'], ['php', 'po', 'pot', 'db']))
        {
            throw new Exception('Format should be either "php", "po", "pot" or "db".');
        }
        if (in_array($config['format'], ['php', 'po', 'pot']))
        {
            if (!isset($config['messagePath']))
            {
                throw new Exception('The configuration file must specify "messagePath".');
            }
            elseif (!is_dir($config['messagePath']))
            {
                throw new Exception("The message path {$config['messagePath']} is not a valid directory.");
            }
        }
        if (empty($config['languages']))
        {
            throw new Exception("Languages cannot be empty.");
        }

        $files = FileHelper::findFiles(realpath($config['sourcePath']), $config);
        //Get framework files 
        $frameworkFiles = FileHelper::findFiles(realpath($config['sourcePath'] . '/../vendor/usniframework'), $config);
        $files = ArrayUtil::merge($files, $frameworkFiles);
        
        $messages = [];
        foreach ($files as $file)
        {
            $messages = array_merge_recursive($messages, $this->extractMessages($file, $config['translator'], $config['ignoreCategories']));
        }
        if (in_array($config['format'], ['php', 'po']))
        {
            foreach ($config['languages'] as $language)
            {
                $dir = $config['messagePath'] . DIRECTORY_SEPARATOR . $language;
                if (!is_dir($dir))
                {
                    @mkdir($dir);
                }
                if ($config['format'] === 'po')
                {
                    $catalog = isset($config['catalog']) ? $config['catalog'] : 'messages';
                    $this->saveMessagesToPO($messages, $dir, $config['overwrite'], $config['removeUnused'], $config['sort'], $catalog, $config['markUnused']);
                }
                else
                {
                    $this->saveMessagesToPHP($messages, $dir, $config['overwrite'], $config['removeUnused'], $config['sort'], $config['markUnused']);
                }
            }
        }
        elseif ($config['format'] === 'db')
        {
            $db = \Yii::$app->get(isset($config['db']) ? $config['db'] : 'db');
            if (!$db instanceof \yii\db\Connection)
            {
                throw new Exception('The "db" option must refer to a valid database application component.');
            }
            $sourceMessageTable = isset($config['sourceMessageTable']) ? $config['sourceMessageTable'] : '{{%source_message}}';
            $messageTable = isset($config['messageTable']) ? $config['messageTable'] : '{{%message}}';
            $this->saveMessagesToDb(
                $messages, $db, $sourceMessageTable, $messageTable, $config['removeUnused'], $config['languages'], $config['markUnused']
            );
        }
        elseif ($config['format'] === 'pot')
        {
            $catalog = isset($config['catalog']) ? $config['catalog'] : 'messages';
            $this->saveMessagesToPOT($messages, $config['messagePath'], $catalog);
        }
    }

}
