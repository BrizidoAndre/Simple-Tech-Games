<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "pieces".
 *
 * @property int $id
 * @property int $game_id
 * @property string $url
 * @property int $position
 *
 * @property Games $game
 * @property PlayerPieces[] $playerPieces
 */
class Pieces extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pieces';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['game_id', 'url', 'position'], 'required'],
            [['game_id', 'position'], 'integer'],
            [['url'], 'string', 'max' => 255],
            [['game_id'], 'exist', 'skipOnError' => true, 'targetClass' => Games::class, 'targetAttribute' => ['game_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'game_id' => 'Game ID',
            'url' => 'Url',
            'position' => 'Position',
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
     * Gets query for [[PlayerPieces]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPlayerPieces()
    {
        return $this->hasMany(PlayerPieces::class, ['piece_id' => 'id']);
    }

}
