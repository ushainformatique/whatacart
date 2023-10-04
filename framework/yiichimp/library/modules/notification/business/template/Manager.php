<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\modules\notification\business\template;

use usni\library\modules\notification\dao\NotificationDAO;
use usni\library\modules\notification\dto\TemplateFormDTO;
use usni\library\utils\ArrayUtil;
use usni\library\modules\notification\dto\TemplateGridViewDTO;
use usni\UsniAdaptor;
use yii\base\InvalidParamException;
/**
 * Manager class for notification layout
 *
 * @package usni\library\modules\notification\business\template
 */
class Manager extends \usni\library\business\Manager
{
    /**
     * inheritdoc
     */
    public function getBrowseModels($modelClass)
    {
        return NotificationDAO::getTemplates($this->language);
    }
    
    /**
     * inheritdoc
     */
    public function loadModel($modelClass, $id)
    {
        $model = NotificationDAO::getTemplate($id, $this->language);
        if ($model === null)
        {
            throw new InvalidParamException("Id is not valid: $id");
        }
        $model['notification_layout'] = $this->getNotificationLayoutName($model['layout_id']);
        return $model;
    }
    
    /**
     * Gets layout name.
     * @param integer $layoutId
     * @return string
     */
    public function getNotificationLayoutName($layoutId)
    {
        $layout = NotificationDAO::getLayout($layoutId, $this->language);
        if(!empty($layout))
        {
            return $layout['name'];
        }
        return UsniAdaptor::t('application', '(not set)');
    }
    
    /**
     * inheritdoc
     * @param TemplateFormDTO $formDTO
     */
    public function processEdit($formDTO)
    {
        parent::processEdit($formDTO);
        $layouts = NotificationDAO::getLayouts($this->language);
        $layoutOptions = ArrayUtil::map($layouts, 'id', 'name');
        $formDTO->setLayoutOptions($layoutOptions);
    }
    
    /**
     * inheritdoc
     * @param TemplateGridViewDTO $gridViewDTO
     */
    public function processList($gridViewDTO)
    {
        parent::processList($gridViewDTO);
        $layouts = NotificationDAO::getLayouts($this->language);
        $layoutOptions = ArrayUtil::map($layouts, 'id', 'name');
        $gridViewDTO->setLayoutOptions($layoutOptions);
    }
    
    /**
     * Process grid preview
     * @param int $id
     * @return string
     */
    public function processGridPreview($id)
    {
        $notificationTemplate   = NotificationDAO::getTemplate($id, $this->language);
        if($notificationTemplate['layout_id'] != null)
        {
            $layout = NotificationDAO::getLayout($notificationTemplate['layout_id'], $this->language);
        }
        else
        {
            $layout['content'] = '{{####content####}}';
        }
        return str_replace(
                            [
                                '{{####title####}}', 
                                '{{####description####}}', 
                                '{{####content####}}'
                            ],
                            [
                                UsniAdaptor::app()->configManager->getValue('application', 'siteName'), 
                                UsniAdaptor::app()->configManager->getValue('application', 'siteDescription'), 
                                $notificationTemplate['content']
                            ],
                            $layout['content']);
    }
    
    /**
     * Process preview
     * @param array $data
     * @return string
     */
    public function processPreview($data)
    {
        if($data['layout_id'] != null)
        {
            $layout = NotificationDAO::getLayout($data['layout_id'], $this->language);
        }
        else
        {
            $layout['content'] = '{{####content####}}';
        }
        return str_replace(
                            [
                                '{{####title####}}', 
                                '{{####description####}}', 
                                '{{####content####}}'
                            ],
                            [
                                UsniAdaptor::app()->configManager->getValue('application', 'siteName'), 
                                UsniAdaptor::app()->configManager->getValue('application', 'siteDescription'), 
                                $data['content']
                            ],
                            $layout['content']);
    }
}