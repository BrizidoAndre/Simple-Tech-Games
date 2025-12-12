<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "admin".
 *
 * @property int $id
 * @property int $user_id
 * @property bool $first_acess
 * @property string $created_at
 *
 * @property FirstAccess[] $firstAccesses
 * @property Logs[] $logs
 * @property Users $user
 */
class Admin extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'admin';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['first_acess'], 'default', 'value' => 1],
            [['user_id'], 'required'],
            [['user_id'], 'integer'],
            [['first_acess'], 'boolean'],
            [['created_at'], 'safe'],
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
            'first_acess' => 'First Acess',
            'created_at' => 'Created At',
        ];
    }

    /**
     * Gets query for [[FirstAccesses]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFirstAccesses()
    {
        return $this->hasMany(FirstAccess::class, ['admin_id' => 'id']);
    }

    /**
     * Gets query for [[Logs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLogs()
    {
        return $this->hasMany(Logs::class, ['admin_id' => 'id']);
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
