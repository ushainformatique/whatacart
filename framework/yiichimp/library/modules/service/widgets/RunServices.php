<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\modules\service\widgets;

use usni\UsniAdaptor;
use yii\helpers\Html;
use usni\library\modules\users\models\User;
/**
 * RunServices class file.
 * 
 * @package usni\library\modules\service\widgets
 */
class RunServices extends \yii\bootstrap\Widget
{
    /**
     * inheritdoc
     */
    public function run()
    {
        if(UsniAdaptor::app()->authorizationManager->isSuperUser(User::SUPER_USER_ID))
        {
            echo $this->renderLinkOnIndexPageByPermission(UsniAdaptor::t('service', 'System Configuration'),
                                                                          UsniAdaptor::createUrl('service/default/check-system'),
                                                                          'service.checksystem');
            echo $this->renderLinkOnIndexPageByPermission(UsniAdaptor::t('auth', 'Rebuild Permissions'),
                                                                          UsniAdaptor::createUrl('service/default/reload-permissions'),
                                                                          'service.loadmodulespermissions');
            echo $this->renderLinkOnIndexPageByPermission(UsniAdaptor::t('auth', 'Rebuild Module Metadata'),
                                                                          UsniAdaptor::createUrl('service/default/reload-module-metadata'),
                                                                          'service.rebuildmodulemetadata');
        }
        echo $this->renderLinkOnIndexPageByPermission(UsniAdaptor::t('application', 'Clear Cache'),
                                                                      UsniAdaptor::createUrl('service/default/index', array('clearCache' => 'true')),
                                                                      'access.service');
        echo $this->renderLinkOnIndexPageByPermission(UsniAdaptor::t('application', 'Clear Assets'),
                                                                      UsniAdaptor::createUrl('service/default/clear-assets'),
                                                                      'access.service');
    }
    
    /**
     * Renders link on index page by permission.
     * @param string $label
     * @param string $url
     * @param string $permission
     * @return string
     */
    public function renderLinkOnIndexPageByPermission($label, $url, $permission)
    {
        $content = null;
        if(UsniAdaptor::app()->user->can($permission))
        {
            $buttonLabel    = UsniAdaptor::t('application', 'Run');
            $runButton      = Html::a($buttonLabel, $url, ['class' => 'btn btn-primary']);
            $content = "<tr>
                            <td>" . $label . "</td>
                            <td style='width: 30%'>" . $runButton . "</td>
                        </tr>";
        }
        return $content;
    }
}
