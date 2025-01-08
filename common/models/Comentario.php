<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "comentario".
 *
 * @property int $id
 * @property string|null $descricao
 * @property int|null $avaliacao
 * @property string|null $datacriacao
 * @property int|null $produto_id
 * @property int|null $utilizadorperfil_id
 *
 * @property Produto $produto
 * @property Utilizadorperfil $utilizadorperfil
 */
class Comentario extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'comentario';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['avaliacao', 'produto_id', 'utilizadorperfil_id'], 'integer'],
            [['datacriacao'], 'safe'],
            [['descricao'], 'string', 'max' => 255],
            [['produto_id'], 'exist', 'skipOnError' => true, 'targetClass' => Produto::class, 'targetAttribute' => ['produto_id' => 'id']],
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
            'descricao' => 'Descricao',
            'avaliacao' => 'Avaliacao',
            'datacriacao' => 'Datacriacao',
            'produto_id' => 'Produto ID',
            'utilizadorperfil_id' => 'Utilizadorperfil ID',
        ];
    }

    /**
     * Gets query for [[Produto]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProduto()
    {
        return $this->hasOne(Produto::class, ['id' => 'produto_id']);
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
