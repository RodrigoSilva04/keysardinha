<?php

namespace common\models;

use Bluerhinos\phpMQTT;
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
    private $_total_comprado;

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
            [['nome'], 'required'],
            [['descricao'], 'string'],
            [['preco'], 'number'],
            [['datalancamento'], 'date', 'format' => 'yyyy-MM-dd'],
            [['stockdisponivel', 'categoria_id', 'desconto_id', 'iva_id'], 'integer'],
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
     * Gets query for [[Chavedigitals]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getChavedigitals()
    {
        return $this->hasMany(Chavedigital::class, ['produto_id' => 'id']);
    }
    /**
     * Gets query for [[Comentarios]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getComentarios()
    {
        return $this->hasMany(Comentario::class, ['produto_id' => 'id']);
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

    /**
     * Gets query for [[Linhafaturas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLinhafaturas()
    {
        return $this->hasMany(Linhafatura::class, ['produto_id' => 'id']);
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
    public function calcularDescontoPreco()
    {
        return $this->preco - ($this->preco * $this->desconto->percentagem / 100);
    }
    
    /*public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes); // TODO: Change the autogenerated stub

        //Obter dados do registo em causa
        $id=$this->id;
        $nome=$this->nome;
        $descricao=$this->descricao;
        $preco=$this->preco;
        $imagem=$this->imagem;
        $datalancamento=$this->datalancamento;
        $stockdisponivel=$this->stockdisponivel;
        $categoria_id=$this->categoria_id;
        $desconto_id=$this->desconto_id;
        $iva_id=$this->iva_id;

        $myObj=new \stdClass();
        $myObj->id=$id;
        $myObj->nome=$nome;
        $myObj->descricao=$descricao;
        $myObj->preco=$preco;
        $myObj->imagem=$imagem;
        $myObj->datalancamento=$datalancamento;
        $myObj->stockdisponivel=$stockdisponivel;
        $myObj->categoria_id=$categoria_id;
        $myObj->desconto_id=$desconto_id;
        $myObj->iva_id=$iva_id;

        $myJSON = json_encode($myObj);
        if($insert)
            $this->FazPublishNoMosquitto("produto/insert","Foi criado um novo produto : " . $myJSON);
        else
            $this->FazPublishNoMosquitto("produto/update","Foi alterado um produto : " .$myJSON);
    }


    public function afterDelete()
    {
        parent::afterDelete(); // TODO: Change the autogenerated stub

        $prod_id= $this->id;
        $myObj=new \stdClass();
        $myObj->id=$prod_id;
        $myJSON = json_encode($myObj);

        $this->FazPublishNoMosquitto("produto/delete", "Foi eliminado um produto : " . $myJSON);



    }

    public function FazPublishNoMosquitto($canal,$msg)
    {
        $server = "localhost";
        $port = 1883;
        $username = ""; // set your username
        $password = ""; // set your password
        $client_id = "phpMQTT-publisher"; // unique!
        $mqtt = new phpMQTT($server, $port, $client_id);
        if ($mqtt->connect(true, NULL, $username, $password))
        {
            $mqtt->publish($canal, $msg, 0);
            $mqtt->close();
        }
        else { file_put_contents("debug.output","Time out!"); }
    }*/

    public function getTotalComprado()
    {
        return $this->_total_comprado;
    }

    public function setTotalComprado($value)
    {
        $this->_total_comprado = $value;
    }
}
