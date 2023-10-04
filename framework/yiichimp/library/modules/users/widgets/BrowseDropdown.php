<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\modules\users\widgets;

use usni\UsniAdaptor;
use usni\library\modules\users\models\User as UserModel;
use usni\library\utils\ArrayUtil;
/**
 * Renders the browse dropdown on detail or edit view
 *
 * @package usni\library\modules\users\widgets
 */
class BrowseDropdown extends \usni\library\widgets\BrowseDropdown
{
    /**
     * inheritdoc
     */
    public function filterBrowseData()
    {
        $model  = $this->model;
        $user   = UsniAdaptor::app()->user->getIdentity();
        if(UsniAdaptor::app()->user->can($this->permission))
        {
            $data = ArrayUtil::map($this->data, 'id', $this->textAttribute);
        }
        else
        {
            //Logged in user can view or update models which he has created or his own record in the dropdown
            $filteredModels  = array();
            foreach($this->data as $value)
            {
                //If ids are not equal
                if($value['id'] != $model['id'])
                {
                    //If created by user are same so that logged in user can see users created by him
                    if($value['created_by'] == $user->id)
                    {
                        $filteredModels[] = $value;
                    }
                }
            }
            $data = ArrayUtil::map($filteredModels, 'id', $this->textAttribute);
        }
        //If logged in user is not super user
        if($user->id != UserModel::SUPER_USER_ID)
        {
            if(array_key_exists(UserModel::SUPER_USER_ID, $data))
            {
                unset($data[UserModel::SUPER_USER_ID]);
            }
        }
        if(array_key_exists($model['id'], $data))
        {
            unset($data[$model['id']]);
        }
        $this->data = $data;
    }
}
