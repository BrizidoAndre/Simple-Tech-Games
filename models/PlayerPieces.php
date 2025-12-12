<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "player_pieces".
 *
 * @property int $id
 * @property int $player_id
 * @property int $piece_id
 * @property int $currentPosition
 *
 * @property Pieces $piece
 * @property Player $player
 */
class PlayerPieces extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'player_pieces';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['player_id', 'piece_id', 'currentPosition'], 'required'],
            [['player_id', 'piece_id', 'currentPosition'], 'integer'],
            [['piece_id'], 'exist', 'skipOnError' => true, 'targetClass' => Pieces::class, 'targetAttribute' => ['piece_id' => 'id']],
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
            'piece_id' => 'Piece ID',
            'currentPosition' => 'Current Position',
        ];
    }

    /**
     * Gets query for [[Piece]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPiece()
    {
        return $this->hasOne(Pieces::class, ['id' => 'piece_id']);
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
