<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace frontend\modules\site\views;

use usni\library\views\UiView;
use yii\widgets\Breadcrumbs;
use yii\helpers\Url;
use usni\UsniAdaptor;
use usni\library\components\UiHtml;
/**
 * BreadcrumbView class file for the front end.
 * @package frontend\modules\site\views
 */
class BreadcrumbView extends UiView
{
    /**
     * @inheritdoc
     */
    protected function renderContent()
    {
        $content = Breadcrumbs::widget(
                                        [
                                            'links'                => $this->getView()->params['breadcrumbs'],
                                            'homeLink'             => $this->getHomeLink(),
                                        ]);
        return UiHtml::tag('div', $content, ['class' => 'container']);
    }

    /**
     * Gets home link.
     * @return string
     */
    protected function getHomeLink()
    {
        return [
                'label' => UsniAdaptor::t('application', 'Home'),
                'url'   => Url::home()
                ];
    }
}
