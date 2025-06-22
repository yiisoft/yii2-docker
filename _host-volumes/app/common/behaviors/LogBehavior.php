<?php

namespace app\common\behaviors;

use yii;
use yii\base\Behavior;
use yii\base\ModelEvent;
use yii\db\AfterSaveEvent;
use yii\db\BaseActiveRecord;

class LogBehavior extends Behavior
{
    public function events()
    {
        return [
            BaseActiveRecord::EVENT_AFTER_UPDATE => 'logUpdate',
            BaseActiveRecord::EVENT_AFTER_INSERT => 'logCreation',
            BaseActiveRecord::EVENT_BEFORE_DELETE => 'logDeletion',
        ];
    }

    public function logCreation(AfterSaveEvent $event)
    {
        $this->log('Created new record:' . print_r($event->sender->attributes, 1));
    }

    public function logDeletion(ModelEvent $event)
    {
        $this->log('Deleted record:' . print_r($event->sender->id, 1));
    }
    public function logUpdate(AfterSaveEvent $event)
    {
        if (!empty($event->changedAttributes)) {
            $changedAttributesString = 'Changed ';
            foreach ($event->changedAttributes as $name => $value) {
                $changedAttributesString .= $name . ' from ' . $value . ' to ' . $event->sender->getAttribute($name);
            }
            $this->log('Updated record: ' . $event->sender->id . '. ' . $changedAttributesString);
        }
    }

    protected function log(string $message)
    {
        Yii::info($message, 'track');
    }
}
