<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "activity".
 *
 * @property string $activity_type
 * @property string $activity_name
 * @property string $class
 *
 * @property ActivitiesLog[] $activitiesLogs
 */
class Activity extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'activity';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['activity_type', 'activity_name', 'class'], 'required'],
            [['activity_type'], 'string', 'max' => 32],
            [['activity_name', 'class'], 'string', 'max' => 255],
            [['activity_type'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'activity_type' => 'Activity Type',
            'activity_name' => 'Activity Name',
            'class' => 'Class',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActivitiesLogs()
    {
        return $this->hasMany(ActivitiesLog::className(), ['activity_type' => 'activity_type']);
    }
}
