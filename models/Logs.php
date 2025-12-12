<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "logs".
 *
 * @property int $id
 * @property int $createtimestamp
 * @property string $tipo
 * @property string $descrição
 * @property int $admin_id
 *
 * @property Admin $admin
 */
class Logs extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'logs';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['createtimestamp', 'tipo', 'descrição', 'admin_id'], 'required'],
            [['createtimestamp', 'admin_id'], 'integer'],
            [['tipo', 'descrição'], 'string', 'max' => 255],
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
            'createtimestamp' => 'Createtimestamp',
            'tipo' => 'Tipo',
            'descrição' => 'Descrição',
            'admin_id' => 'Admin ID',
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
