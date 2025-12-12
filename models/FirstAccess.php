<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "first_access".
 *
 * @property int $id
 * @property int $admin_id
 * @property string $link
 * @property int $created_at
 *
 * @property Admin $admin
 */
class FirstAccess extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'first_access';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['admin_id', 'link', 'created_at'], 'required'],
            [['admin_id', 'created_at'], 'integer'],
            [['link'], 'string', 'max' => 255],
            [['admin_id'], 'exist', 'skipOnError' => true, 'targetClass' => Admin::class, 'targetAttribute' => ['admin_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'admin_id' => 'Admin ID',
            'link' => 'Link',
            'created_at' => 'Created At',
        ];
    }

    /**
     * Gets query for [[Admin]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAdmin()
    {
        return $this->hasOne(Admin::class, ['id' => 'admin_id']);
    }

}
