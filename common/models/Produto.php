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
 * @property int|null $desconto_id
 * @property int $iva_id
 *
 * @property Categoria $categoria
 * @property Desconto $desconto
 * @property Favoritos[] $favoritos
 * @property Iva $iva
 * @property Linhacarrinho[] $linhacarrinhos
 */
class Produto extends \yii\db\ActiveRecord
{

    public $imagemFile;
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
            [['stockdisponivel', 'categoria_id', 'desconto_id', 'iva_id'], 'integer'],
            [['iva_id'], 'required'],
            [['nome', 'imagem'], 'string', 'max' => 255],
            [['desconto_id'], 'exist', 'skipOnError' => true, 'targetClass' => Desconto::class, 'targetAttribute' => ['desconto_id' => 'id']],
            [['categoria_id'], 'exist', 'skipOnError' => true, 'targetClass' => Categoria::class, 'targetAttribute' => ['categoria_id' => 'id']],
            [['iva_id'], 'exist', 'skipOnError' => true, 'targetClass' => Iva::class, 'targetAttribute' => ['iva_id' => 'id']],
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
            'desconto_id' => 'Desconto ID',
            'iva_id' => 'Iva ID',
        ];
    }

    /**
     * Gets query for [[Categoria]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategoria()
    {
        return $this->hasOne(Categoria::class, ['id' => 'categoria_id']);
    }

    /**
     * Gets query for [[Desconto]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDesconto()
    {
        return $this->hasOne(Desconto::class, ['id' => 'desconto_id']);
    }

    /**
     * Gets query for [[Favoritos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFavoritos()
    {
        return $this->hasMany(Favoritos::class, ['produto_id' => 'id']);
    }

    /**
     * Gets query for [[Iva]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIva()
    {
        return $this->hasOne(Iva::class, ['id' => 'iva_id']);
    }

    /**
     * Gets query for [[Linhacarrinhos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLinhacarrinhos()
    {
        return $this->hasMany(Linhacarrinho::class, ['produto_id' => 'id']);
    }
    public function uploadImagem()
    {
        // Verifica se um arquivo foi enviado
        if ($this->imagemFile && $this->validate()) {
            // Gera um nome único para a imagem (com extensão)
            $fileName = $this->imagemFile->baseName . '.' . $this->imagemFile->extension;

            // Caminho onde a imagem será salva
            $uploadPath = Yii::getAlias('@frontend/web/imagensjogos');

            // Salva a imagem no diretório 'imagensjogos'
            $this->imagemFile->saveAs($fileName);

            // Atualiza o campo 'imagem' com o nome da imagem salva
            $this->imagem =  $fileName;
            return true;
        }
        return false;
    }
}
