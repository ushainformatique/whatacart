<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\components;

use yii\base\Model;

/**
 * BaseModelConfig class file. This would act as a base class where you would like to change the config
 * for the model which includes, labels, hint and scenarios.
 * 
 * @package usni\library\components
 * @see usni\library\db\checkIfExtendedConfigExists and usni\library\db\getModelConfig
 */
class BaseModelConfig extends \yii\base\Component
{
    /**
     * Parent class instance from which config class is called
     * @var string 
     */
    public $parent;

    /**
     * Class constructor
     */
    public function __construct($parent)
    {
        $this->parent = $parent;
    }

    /**
     * @inheritdoc
     * 
     * @see yii\base\Model::scenarios()
     */
    public function scenarios()
    {
        $scenarios = [Model::SCENARIO_DEFAULT => []];
        foreach ($this->parent->getValidators() as $validator)
        {
            foreach ($validator->on as $scenario)
            {
                $scenarios[$scenario] = [];
            }
            foreach ($validator->except as $scenario)
            {
                $scenarios[$scenario] = [];
            }
        }
        $names = array_keys($scenarios);

        foreach ($this->parent->getValidators() as $validator)
        {
            if (empty($validator->on) && empty($validator->except))
            {
                foreach ($names as $name)
                {
                    foreach ($validator->attributes as $attribute)
                    {
                        $scenarios[$name][$attribute] = true;
                    }
                }
            }
            elseif (empty($validator->on))
            {
                foreach ($names as $name)
                {
                    if (!in_array($name, $validator->except, true))
                    {
                        foreach ($validator->attributes as $attribute)
                        {
                            $scenarios[$name][$attribute] = true;
                        }
                    }
                }
            }
            else
            {
                foreach ($validator->on as $name)
                {
                    foreach ($validator->attributes as $attribute)
                    {
                        $scenarios[$name][$attribute] = true;
                    }
                }
            }
        }

        foreach ($scenarios as $scenario => $attributes)
        {
            if (!empty($attributes))
            {
                $scenarios[$scenario] = array_keys($attributes);
            }
        }
        return $scenarios;
    }
}