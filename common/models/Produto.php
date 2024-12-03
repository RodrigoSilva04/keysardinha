<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "produto".
 *
 * @property int $id
 * @property string|null $nome
 * @property string|null $descricao
 * @property float|null $preco
 * @property string|null $imagem
 * @property string|null $datalancamento
 * @property int|null $stockdisponivel
 * @property int|null $categoria_id
 */
class Produto extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'produto';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['descricao'], 'string'],
            [['preco'], 'number'],
            [['datalancamento'], 'safe'],
            [['stockdisponivel', 'categoria_id'], 'integer'],
            [['nome', 'imagem'], 'string', 'max' => 255],
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
            'descricao' => 'Descricao',
            'preco' => 'Preco',
            'imagem' => 'Imagem',
            'datalancamento' => 'Datalancamento',
            'stockdisponivel' => 'Stockdisponivel',
            'categoria_id' => 'Categoria ID',
        ];
    }

    public function getCategoria()
    {
        return $this->hasOne(Categoria::class, ['id' => 'categoria_id']);
    }
}
