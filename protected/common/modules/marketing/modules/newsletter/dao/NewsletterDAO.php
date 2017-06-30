<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace newsletter\dao;

use usni\UsniAdaptor;
/**
 * NewsletterDAO class file.
 * 
 * @package newsletter\dao
 */
class NewsletterDAO
{
    /**
     * Get by id.
     * @param integer $id
     * @param string $language
     * @return array
     */
    public static function getById($id, $language)
    {
        $table      = UsniAdaptor::tablePrefix() . 'newsletter';
        $trTable    = UsniAdaptor::tablePrefix() . 'newsletter_translated';
        $sql        = "SELECT n.*, nt.content FROM $table n, $trTable nt "
                    . "WHERE n.id = :id AND nt.owner_id = n.id AND nt.language = :lang";
        return UsniAdaptor::app()->db->createCommand($sql, [':id' => $id, ':lang' => $language])->queryOne();
    }
}