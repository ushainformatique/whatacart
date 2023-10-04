<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\widgets\forms;

use usni\library\utils\Html;
/**
 * NameWithAliasFormField class file
 * @package usni\library\widgets\forms
 */
class NameWithAliasFormField extends \yii\widgets\InputWidget
{
    /**
     * Alias id associated with the name field. If not null than calculated based on the name value.
     * @var string
     */
    public $aliasId = null;

    /**
     * Render name field using alias.
     * @return void
     */
    public function run()
    {
        $this->aliasId      = Html::getInputId($this->model, 'alias');
        $this->options['onkeyup'] = 'javascript:getAlias($(this).attr("id"), "' . $this->aliasId . '")';
        $this->options['class']   = 'form-control';
        echo Html::activeTextInput($this->model, $this->attribute, $this->options);
    }
}