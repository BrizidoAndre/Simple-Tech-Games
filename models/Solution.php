<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "solution".
 *
 * @property int $id
 * @property int $player_id
 * @property int $time_taken
 * @property int $game_id
 * @property string $resolution_date
 *
 * @property Games $game
 * @property Player $player
 */
class Solution extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'solution';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['player_id', 'time_taken', 'game_id', 'resolution_date'], 'required'],
            [['player_id', 'time_taken', 'game_id'], 'integer'],
            [['resolution_date'], 'safe'],
            [['game_id'], 'exist', 'skipOnError' => true, 'targetClass' => Games::class, 'targetAttribute' => ['game_id' => 'id']],
            [['player_id'], 'exist', 'skipOnError' => true, 'targetClass' => Player::class, 'targetAttribute' => ['player_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'player_id' => 'Player ID',
            'time_taken' => 'Time Taken',
            'game_id' => 'Game ID',
            'resolution_date' => 'Resolution Date',
        ];
    }

    /**
     * Gets query for [[Game]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGame()
    {
        return $this->hasOne(Games::class, ['id' => 'game_id']);
    }

    /**
     * Gets query for [[Player]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPlayer()
    {
        return $this->hasOne(Player::class, ['id' => 'player_id']);
    }

}
