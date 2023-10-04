<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\bootstrap;

use usni\library\utils\Html;
use yii\bootstrap\BootstrapAsset;
use yii\bootstrap\Widget;
/**
 * Label renders a label bootstrap component.
 *
 * For example,
 *
 * ```php
 * // a label with configuration
 * echo Label::widget([
 *     'content' => 'Hello World',
 *     'modifier' => 'info'
 * ]);
 * ```
 * @see http://getbootstrap.com/components/#labels
 * @package usni\library\bootstrap
 */
class Label extends Widget
{
    /**
     * Content to be rendered within the label.
     * @var string
     */
    public $content;
    /**
     * @var string modify the label color e.g. info, danger etc.
     */
    public $modifier;

    /**
     * Initializes the widget.
     * If you override this method, make sure you call the parent implementation first.
     */
    public function init()
    {
        parent::init();
        Html::addCssClass($this->options, 'label');
        if($this->modifier != null)
        {
            Html::addCssClass($this->options, 'label-' . $this->modifier);
        }
    }

    /**
     * Renders the widget.
     */
    public function run()
    {
        echo Html::tag('span', $this->content, $this->options);
        BootstrapAsset::register($this->getView());
    }
}
