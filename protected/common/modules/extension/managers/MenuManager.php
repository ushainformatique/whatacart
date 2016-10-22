<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\extension\managers;

use common\modules\extension\models\Extension;
use usni\library\managers\BaseMenuManager;
use usni\UsniAdaptor;
use usni\library\modules\auth\managers\AuthManager;
use usni\library\utils\AdminUtil;
/**
 * MenuManager class file.
 *
 * @package common\modules\extension\managers
 */
class MenuManager extends BaseMenuManager
{
    /**
     * Get sidebar items.
     * @param array $items
     */
    public static function getSidebarItems(& $items)
    {
        $items ['sidebar']   = [];
        $modelClassName      = static::getModelClassName();
        $user                = UsniAdaptor::app()->user->getUserModel();
        if(AuthManager::checkAccess($user, 'access.extension'))
        {
            $label             = AdminUtil::wrapSidebarMenuLabel(static::getLabel($modelClassName));
            $items ['sidebar'] =    [
                                        [
                                            'label'       => static::renderIcon() . $label,
                                            'url'         => ['#'],
                                            'itemOptions' => ['class' => 'navblock-header'],
                                            'items'       => [
                                                                [
                                                                    'label'       => UsniAdaptor::t('extension', 'Enhancements'),
                                                                    'url'         => ['/enhancement/default/manage'],
                                                                ],
                                                                [
                                                                    'label'       => UsniAdaptor::t('extension', 'Payment Methods'),
                                                                    'url'         => ['/payment/default/manage'],
                                                                ],
                                                                [
                                                                    'label'       => UsniAdaptor::t('extension', 'Shipping Methods'),
                                                                    'url'         => ['/shipping/default/manage'],
                                                                ],
                                                                [
                                                                    'label'       => UsniAdaptor::t('extension', 'Modules'),
                                                                    'url'         => ['/extension/module/manage'],
                                                                ],
                                                                [
                                                                    'label'       => UsniAdaptor::t('extension', 'Modifications'),
                                                                    'url'         => ['/extension/modification/manage'],
                                                                ]
                                                             ]
                                        ]
                            ];
        }
    }
    
    /**
     * @inheritdoc
     */
    public static function getModelClassName()
    {
        return Extension::className();
    }
    
    /**
     * @inheritdoc
     */
    public static function getIcon()
    {
        return 'puzzle-piece';
    }
    
    /**
     * @inheritdoc
     */
    public static function getModuleUniqueId()
    {
        return 'extension';
    }
    
    /**
     * @inheritdoc
     */
    public static function getLabel($modelClassName)
    {
        return UsniAdaptor::t('extension', 'Extensions');
    }
}