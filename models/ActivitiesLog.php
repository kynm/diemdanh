<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "activities_log".
 *
 * @property int $activity_log_id
 * @property string $activity_type
 * @property string $description
 * @property int $user_id
 * @property int $create_at
 *
 * @property Activity $activityType
 * @property User $user
 */
class ActivitiesLog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'activities_log';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['activity_type', 'description', 'user_id', 'create_at'], 'required'],
            [['user_id', 'create_at'], 'integer'],
            [['activity_type'], 'string', 'max' => 32],
            [['description'], 'string', 'max' => 255],
            [['activity_type'], 'exist', 'skipOnError' => true, 'targetClass' => Activity::className(), 'targetAttribute' => ['activity_type' => 'activity_type']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'activity_log_id' => 'Activity Log ID',
            'activity_type' => 'Activity Type',
            'description' => 'Hoạt động',
            'user_id' => 'Người thực hiện',
            'create_at' => 'Thời gian',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActivityType()
    {
        return $this->hasOne(Activity::className(), ['activity_type' => 'activity_type']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
