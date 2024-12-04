<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "utilizadorperfil".
 *
 * @property int $id
 * @property string|null $nome
 * @property string|null $dataregisto
 * @property int|null $pontosacumulados
 * @property int|null $carrinho_id
 */
class Utilizadorperfil extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'utilizadorperfil';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id', 'pontosacumulados', 'carrinho_id'], 'integer'],
            [['dataregisto'], 'safe'],
            [['nome'], 'string', 'max' => 100],
            [['id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nome' => 'Nome',
            'dataregisto' => 'Dataregisto',
            'pontosacumulados' => 'Pontosacumulados',
            'carrinho_id' => 'Carrinho ID',
        ];
    }

    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'id']);
    }
}
