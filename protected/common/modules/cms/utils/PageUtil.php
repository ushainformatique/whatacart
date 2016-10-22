<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\cms\utils;

use common\modules\cms\models\Page;
use common\modules\cms\models\PageTranslated;
use usni\UsniAdaptor;
use frontend\utils\FrontUtil;
use yii\caching\DbDependency;
/**
 * PageUtil class file
 * 
 * @package common\modules\cms\utils
 */
class PageUtil
{
    /**
     * Get page by alias
     * @param string $alias
     * @param string $language
     * @param string $theme
     * @return array
     */
    public static function getPageByAlias($alias, $language = null, $theme = null)
    {
        if($theme == null)
        {
            $theme                  = FrontUtil::getThemeName();
        }
        if($language == null)
        {
            $language               = UsniAdaptor::app()->languageManager->getContentLanguage();
        }
        $pageTable              = Page::tableName();
        $pageTrTable            = PageTranslated::tableName();
        $sql                    = "SELECT p.*, pt.name, pt.alias, pt.content, pt.menuitem, pt.summary, pt.metakeywords, pt.metadescription 
                                   FROM $pageTable p, $pageTrTable pt 
                                   WHERE pt.alias = :alias AND pt.language = :lan AND pt.owner_id = p.id AND p.theme = :theme";
        $connection             = UsniAdaptor::app()->getDb();
        $dependency             = new DbDependency(['sql' => "SELECT MAX(modified_datetime) FROM $pageTable"]);
        return $connection->createCommand($sql, [':alias' => $alias, ':lan' => $language, ':theme' => $theme])->cache(0, $dependency)->queryOne();
    }
}