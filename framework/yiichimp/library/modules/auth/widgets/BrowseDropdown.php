<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\modules\auth\widgets;

/**
 * Renders the browse dropdown on detail or edit view for group
 *
 * @package usni\library\modules\auth\widgets
 */
class BrowseDropdown extends \usni\library\widgets\BrowseDropdown
{   
    /**
     * @inheritdoc
     */
    public function prepareFilteredModelsForDisplay($filteredModels)
    {
        $data = [];
        foreach($filteredModels as $model)
        {
            $data[$model['id']] = str_repeat('-', $model['level']) . $model['name'];
        }
        return $data;
    }
}
