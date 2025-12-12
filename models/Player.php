<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "player".
 *
 * @property int $id
 * @property int $user_id
 * @property int $deleted
 *
 * @property PlayerPieces[] $playerPieces
 * @property Solution[] $solutions
 * @property Token[] $tokens
 * @property Users $user
 */
class Player extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'player';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['deleted'], 'default', 'value' => 0],
            [['user_id'], 'required'],
            [['user_id', 'deleted'], 'integer'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'deleted' => 'Deleted',
        ];
    }

    /**
     * Gets query for [[PlayerPieces]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPlayerPieces()
    {
        return $this->hasMany(PlayerPieces::class, ['player_id' => 'id']);
    }

    /**
     * Gets query for [[Solutions]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSolutions()
    {
        $query = $this->hasMany(Solution::class, ['player_id' => 'id']);
        $query->orderBy('resolution_date desc');
        $query->limit(10);
        return $query;
    }

    /**
     * Gets query for [[Tokens]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTokens()
    {
        return $this->hasMany(Token::class, ['player_id' => 'id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::class, ['id' => 'user_id']);
    }

}
