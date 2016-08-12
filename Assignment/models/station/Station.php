<?php

namespace app\models\station;

use Yii;

/**
 * This is the model class for table "station".
 *
 * @property integer $id
 * @property string $name
 * @property string $position_station
 * @property integer $line_id
 */
class Station extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'station';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['line_id'], 'integer'],
            [['name'], 'string', 'max' => 80],
            [['position_station'], 'string', 'max' => 15],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'position_station' => 'Position Station',
            'line_id' => 'Line ID',
        ];
    }
}
