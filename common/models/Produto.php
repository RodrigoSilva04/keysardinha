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
 * @property int|null $chaveigital_id
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
            [['id'], 'required'],
            [['id', 'stockdisponivel', 'chaveigital_id', 'categoria_id'], 'integer'],
            [['descricao'], 'string'],
            [['preco'], 'number'],
            [['datalancamento'], 'safe'],
            [['nome', 'imagem'], 'string', 'max' => 255],
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
            'descricao' => 'Descricao',
            'preco' => 'Preco',
            'imagem' => 'Imagem',
            'datalancamento' => 'Datalancamento',
            'stockdisponivel' => 'Stockdisponivel',
            'chaveigital_id' => 'Chaveigital ID',
            'categoria_id' => 'Categoria ID',
        ];
    }
    public function getCategoria()
    {
        return $this->hasOne(Categoria::class, ['id' => 'categoria_id']);
    }

}
