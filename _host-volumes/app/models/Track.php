<?php

namespace app\models;

use app\common\behaviors\LogBehavior;
use Yii;

/**
 * This is the model class for table "Track".
 *
 * @property int $id
 * @property string $track_number
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property string|null $status
 */
class Track extends \yii\db\ActiveRecord
{

    const SCENARIO_CREATE = "create";
    const SCENARIO_UPDATE = "update";

    public function init()
    {
        parent::init();

        $this->scenario = self::SCENARIO_CREATE;
    }

    public function scenarios(): array
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_CREATE] = ['track_number', 'status'];
        $scenarios[self::SCENARIO_UPDATE] = ['status'];
        return $scenarios;
    }

    /**
     * ENUM field values
     */
    const STATUS_NEW = 'new';
    const STATUS_IN_PROGRESS = 'in_progress';
    const STATUS_COMPLETED = 'completed';
    const STATUS_FAILED = 'failed';
    const STATUS_CANCELED = 'canceled';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'Track';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['updated_at', 'status'], 'default', 'value' => null],
            [['track_number', 'status'], 'required', 'on' => [self::SCENARIO_CREATE]],
            [['status'], 'required', 'on' => [self::SCENARIO_UPDATE]],
            [['status'], 'string'],
            [['track_number'], 'string', 'length' => [5, 255]],
            ['status', 'in', 'range' => array_keys(self::optsStatus())],
            [['track_number'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'track_number' => 'Track Number',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status' => 'Status',
        ];
    }


    /**
     * column status ENUM value labels
     * @return string[]
     */
    public static function optsStatus()
    {
        return [
            self::STATUS_NEW => 'new',
            self::STATUS_IN_PROGRESS => 'in_progress',
            self::STATUS_COMPLETED => 'completed',
            self::STATUS_FAILED => 'failed',
            self::STATUS_CANCELED => 'canceled',
        ];
    }

    /**
     * @return string
     */
    public function displayStatus()
    {
        return self::optsStatus()[$this->status];
    }

    /**
     * @return bool
     */
    public function isStatusNew()
    {
        return $this->status === self::STATUS_NEW;
    }

    public function setStatusToNew()
    {
        $this->status = self::STATUS_NEW;
    }

    /**
     * @return bool
     */
    public function isStatusInprogress()
    {
        return $this->status === self::STATUS_IN_PROGRESS;
    }

    public function setStatusToInprogress()
    {
        $this->status = self::STATUS_IN_PROGRESS;
    }

    /**
     * @return bool
     */
    public function isStatusCompleted()
    {
        return $this->status === self::STATUS_COMPLETED;
    }

    public function setStatusToCompleted()
    {
        $this->status = self::STATUS_COMPLETED;
    }

    /**
     * @return bool
     */
    public function isStatusFailed()
    {
        return $this->status === self::STATUS_FAILED;
    }

    public function setStatusToFailed()
    {
        $this->status = self::STATUS_FAILED;
    }

    /**
     * @return bool
     */
    public function isStatusCanceled()
    {
        return $this->status === self::STATUS_CANCELED;
    }

    public function setStatusToCanceled()
    {
        $this->status = self::STATUS_CANCELED;
    }

    public function behaviors(): array
    {
        return array_merge(parent::behaviors(), ['class' => LogBehavior::class]);
    }
}
