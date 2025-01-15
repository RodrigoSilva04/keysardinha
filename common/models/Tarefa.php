<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "tarefa".
 *f
 * @property int $id
 * @property string $descricao
 * @property int $feito
 * @property int $user_id
 *
 * @property User $user
 */
class Tarefa extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tarefa';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['descricao', 'feito', 'user_id'], 'required'],
            [['feito', 'user_id'], 'integer'],
            [['descricao'], 'string', 'max' => 30],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'descricao' => 'Descricao',
            'feito' => 'Feito',
            'user_id' => 'User ID',
        ];
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }


}
