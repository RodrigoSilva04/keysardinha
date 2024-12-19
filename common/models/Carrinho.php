<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "carrinho".
 *
 * @property int $id
 * @property string|null $data_criacao
 * @property int|null $cupao_id
 * @property int|null $utilizadorperfil_id
 *
 * @property Cupao $cupao
 * @property Linhacarrinho[] $linhacarrinhos
 * @property Utilizadorperfil $utilizadorperfil
 */
class Carrinho extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'carrinho';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['data_criacao'], 'safe'],
            [['cupao_id', 'utilizadorperfil_id'], 'integer'],
            [['cupao_id'], 'exist', 'skipOnError' => true, 'targetClass' => Cupao::class, 'targetAttribute' => ['cupao_id' => 'id']],
            [['utilizadorperfil_id'], 'exist', 'skipOnError' => true, 'targetClass' => Utilizadorperfil::class, 'targetAttribute' => ['utilizadorperfil_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'data_criacao' => 'Data Criacao',
            'cupao_id' => 'Cupao ID',
            'utilizadorperfil_id' => 'Utilizadorperfil ID',
        ];
    }

    /**
     * Gets query for [[Cupao]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCupao()
    {
        return $this->hasOne(Cupao::class, ['id' => 'cupao_id']);
    }

    /**
     * Gets query for [[Linhacarrinhos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLinhacarrinhos()
    {
        return $this->hasMany(Linhacarrinho::class, ['carrinho_id' => 'id']);
    }

    /**
     * Gets query for [[Utilizadorperfil]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUtilizadorperfil()
    {
        return $this->hasOne(Utilizadorperfil::class, ['id' => 'utilizadorperfil_id']);
    }
}
