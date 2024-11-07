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
            [['id'], 'required'],
            [['id', 'avaliacao', 'produto_id', 'utilizadorperfil_id'], 'integer'],
            [['datacriacao'], 'safe'],
            [['descricao'], 'string', 'max' => 255],
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
            'descricao' => 'Descricao',
            'avaliacao' => 'Avaliacao',
            'datacriacao' => 'Datacriacao',
            'produto_id' => 'Produto ID',
            'utilizadorperfil_id' => 'Utilizadorperfil ID',
        ];
    }
}
