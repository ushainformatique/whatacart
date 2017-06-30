<?php

namespace backend\components;

/**
 * Extend Taggable Behavior to take care of translations
 * 
 * @package backend\components
 */
class ExtendedTaggable extends \dosamigos\taggable\Taggable
{
    /**
     * @param Event $event
     */
    public function afterSave($event)
    {
        if ($this->tagValues === null)
        {
            $this->tagValues = $this->owner->{$this->attribute};
        }

        if (!$this->owner->getIsNewRecord())
        {
            $this->beforeDelete($event);
        }

        $names = array_unique(preg_split(
                '/\s*,\s*/u', preg_replace(
                    '/\s+/u', ' ', is_array($this->tagValues) ? implode(',', $this->tagValues) : $this->tagValues
                ), -1, PREG_SPLIT_NO_EMPTY
        ));

        $relation = $this->owner->getRelation($this->relation);
        $pivot = $relation->via->from[0];
        /** @var ActiveRecord $class */
        $class = $relation->modelClass;
        $rows = [];
        $updatedTags = [];

        foreach ($names as $name)
        {
            //This is the change as name is coming from translated table
            $tag = $class::find()->joinWith('translations')->where($this->name . '= :name', [':name' => $name])->one();

            if ($tag === null)
            {
                $tag = new $class();
                $tag->{$this->name} = $name;
            }

            $tag->{$this->frequency} ++;

            if ($tag->save())
            {
                $tag->saveTranslatedModels();
                $updatedTags[] = $tag;
                $rows[] = [$this->owner->getPrimaryKey(), $tag->getPrimaryKey()];
            }
        }

        if (!empty($rows))
        {
            $this->owner->getDb()
                ->createCommand()
                ->batchInsert($pivot, [key($relation->via->link), current($relation->link)], $rows)
                ->execute();
        }

        $this->owner->populateRelation($this->relation, $updatedTags);
    }
}
