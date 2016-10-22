<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\cms\controllers;

use usni\library\components\UiAdminController;
use usni\UsniAdaptor;
use usni\library\exceptions\MethodNotImplementedException;
/**
 * CmsController class file
 *
 * @package common\modules\cms\controllers
 */
abstract class CmsController extends UiAdminController
{
    use \usni\library\traits\EditViewTranslationTrait;
    
    /**
     * @inheritdoc
     */
    public function pageTitles()
    {
        $modelClass = $this->resolveModelClassName();
        $key        = strtolower(UsniAdaptor::getObjectClassName($modelClass));
        return [
                    'create' => UsniAdaptor::t('application', 'Create') . ' ' . static::getLabel(1),
                    'update' => UsniAdaptor::t('application', 'Update') . ' ' . static::getLabel(1),
                    'view'   => UsniAdaptor::t('application', 'View')   . ' ' . static::getLabel(1),
                    'manage' => UsniAdaptor::t('application', 'Manage') . ' ' . static::getLabel(2),
               ];
    }

    /**
     * Get action to permission map.
     * @return array
     */
    protected function getActionToPermissionsMap()
    {
        $modelClassName             = $this->resolveModelClassName();
        $permissionsMap             = parent::getActionToPermissionsMap();
        $permissionsMap['preview']  = strtolower($modelClassName) . '.preview';
        return $permissionsMap;
    }
    
    /**
     * Get label based on short case model class name.
     * @param int $n
     * @return string
     */
    protected static function getLabel($n = 1)
    {
        throw new MethodNotImplementedException();
    }
}
?>