<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\modules\notification\dao;

use usni\UsniAdaptor;
use yii\caching\DbDependency;
/**
 * NotificationDAO class file
 *
 * @package usni\library\modules\notification\dao
 */
class NotificationDAO
{
    /**
     * Get layouts
     * @param string $language
     * @return array
     */
    public static function getLayouts($language)
    {
        $table      = UsniAdaptor::tablePrefix() . 'notification_layout';
        $trTable    = UsniAdaptor::tablePrefix() . 'notification_layout_translated';
        $dependency = new DbDependency(['sql' => "SELECT MAX(modified_datetime) FROM $table"]);
        $sql        = "SELECT nl.*, nlt.name, nlt.content FROM $table nl, $trTable nlt WHERE nl.id = nlt.owner_id AND nlt.language = :lan";
        return UsniAdaptor::app()->db->createCommand($sql, [':lan' => $language])->cache(0, $dependency)->queryAll();
    }
    
    /**
     * Get layout
     * @param int $id
     * @param string $language  
     * @return array
     */
    public static function getLayout($id, $language)
    {
        $table      = UsniAdaptor::tablePrefix() . 'notification_layout';
        $trTable    = UsniAdaptor::tablePrefix() . 'notification_layout_translated';
        $sql        = "SELECT nl.*, nlt.name, nlt.content FROM $table nl, $trTable nlt WHERE nl.id = :id AND nl.id = nlt.owner_id AND nlt.language = :lan";
        return UsniAdaptor::app()->db->createCommand($sql, [':id' => $id, ':lan' => $language])->queryOne();
    }
    
    /**
     * Get templates
     * @param string $language
     * @return array
     */
    public static function getTemplates($language)
    {
        $table      = UsniAdaptor::tablePrefix() . 'notification_template';
        $trTable    = UsniAdaptor::tablePrefix() . 'notification_template_translated';
        $dependency = new DbDependency(['sql' => "SELECT MAX(modified_datetime) FROM $table"]);
        $sql        = "SELECT nt.*, ntt.subject, ntt.content FROM $table nt, $trTable ntt WHERE nt.id = ntt.owner_id AND ntt.language = :lan";
        return UsniAdaptor::app()->db->createCommand($sql, [':lan' => $language])->cache(0, $dependency)->queryAll();
    }
    
    /**
     * Get template
     * @param int $id
     * @param string $language  
     * @return array
     */
    public static function getTemplate($id, $language)
    {
        $table      = UsniAdaptor::tablePrefix() . 'notification_template';
        $trTable    = UsniAdaptor::tablePrefix() . 'notification_template_translated';
        $sql        = "SELECT nt.*, ntt.subject, ntt.content FROM $table nt, $trTable ntt WHERE nt.id = :id AND nt.id = ntt.owner_id AND ntt.language = :lan";
        return UsniAdaptor::app()->db->createCommand($sql, [':id' => $id, ':lan' => $language])->queryOne();
    }
    
    /**
     * Get template
     * @param string $key
     * @param string $language  
     * @return array
     */
    public static function getTemplateByKey($key, $language)
    {
        $table      = UsniAdaptor::tablePrefix() . 'notification_template';
        $trTable    = UsniAdaptor::tablePrefix() . 'notification_template_translated';
        $sql        = "SELECT nt.*, ntt.subject, ntt.content FROM $table nt, $trTable ntt WHERE nt.notifykey = :nk AND nt.id = ntt.owner_id AND ntt.language = :lan";
        return UsniAdaptor::app()->db->createCommand($sql, [':nk' => $key, ':lan' => $language])->queryOne();
    }
}
