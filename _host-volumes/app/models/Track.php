<?php

declare(strict_types=1);

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
 * @property string $status
 */
class Track extends \yii\db\ActiveRecord
{

    const SCENARIO_CREATE = "create";
    const SCENARIO_UPDATE = "update";

    public function init(): void
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
    public static function tableName(): string
    {
        return 'Track';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
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
    public function attributeLabels(): array
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
    public static function optsStatus(): array
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
    public function displayStatus(): string
    {
        return self::optsStatus()[$this->status];
    }

    /**
     * @return bool
     */
    public function isStatusNew(): bool
    {
        return $this->status === self::STATUS_NEW;
    }

    public function setStatusToNew(): void
    {
        $this->status = self::STATUS_NEW;
    }

    /**
     * @return bool
     */
    public function isStatusInprogress(): bool
    {
        return $this->status === self::STATUS_IN_PROGRESS;
    }

    public function setStatusToInprogress(): void
    {
        $this->status = self::STATUS_IN_PROGRESS;
    }

    /**
     * @return bool
     */
    public function isStatusCompleted(): bool
    {
        return $this->status === self::STATUS_COMPLETED;
    }

    public function setStatusToCompleted(): void
    {
        $this->status = self::STATUS_COMPLETED;
    }

    /**
     * @return bool
     */
    public function isStatusFailed(): bool
    {
        return $this->status === self::STATUS_FAILED;
    }

    public function setStatusToFailed(): void
    {
        $this->status = self::STATUS_FAILED;
    }

    /**
     * @return bool
     */
    public function isStatusCanceled(): bool
    {
        return $this->status === self::STATUS_CANCELED;
    }

    public function setStatusToCanceled(): void
    {
        $this->status = self::STATUS_CANCELED;
    }

    public function behaviors(): array
    {
        return array_merge(parent::behaviors(), ['class' => LogBehavior::class]);
    }
}
