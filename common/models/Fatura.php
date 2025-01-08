<?php

namespace common\models;


use Bluerhinos\phpMQTT;

/**
 * This is the model class for table "fatura".
 *
 * @property int $id
 * @property string|null $datafatura
 * @property float|null $totalciva
 * @property float|null $subtotal
 * @property float|null $valor_total
 * @property string|null $estado
 * @property float|null $descontovalor
 * @property string $datapagamento
 * @property int|null $utilizadorperfil_id
 * @property int|null $metodopagamento_id
 * @property int|null $desconto_id
 * @property int|null $cupao_id
 *
 * @property Cupao $cupao
 * @property Desconto $desconto
 * @property Linhafatura[] $linhafaturas
 * @property Metodopagamento $metodopagamento
 * @property Utilizadorperfil $utilizadorperfil
 */
class Fatura extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'fatura';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['datafatura', 'datapagamento'], 'safe'],
            [['totalciva', 'subtotal', 'valor_total', 'descontovalor'], 'number'],
            [['estado'], 'string'],
            [['datapagamento'], 'required'],
            [['utilizadorperfil_id', 'metodopagamento_id', 'desconto_id', 'cupao_id'], 'integer'],
            [['desconto_id'], 'exist', 'skipOnError' => true, 'targetClass' => Desconto::class, 'targetAttribute' => ['desconto_id' => 'id']],
            [['metodopagamento_id'], 'exist', 'skipOnError' => true, 'targetClass' => Metodopagamento::class, 'targetAttribute' => ['metodopagamento_id' => 'id']],
            [['utilizadorperfil_id'], 'exist', 'skipOnError' => true, 'targetClass' => Utilizadorperfil::class, 'targetAttribute' => ['utilizadorperfil_id' => 'id']],
            [['cupao_id'], 'exist', 'skipOnError' => true, 'targetClass' => Cupao::class, 'targetAttribute' => ['cupao_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'datafatura' => 'Datafatura',
            'totalciva' => 'Totalciva',
            'subtotal' => 'Subtotal',
            'valor_total' => 'Valor Total',
            'estado' => 'Estado',
            'descontovalor' => 'Descontovalor',
            'datapagamento' => 'Datapagamento',
            'utilizadorperfil_id' => 'Utilizadorperfil ID',
            'metodopagamento_id' => 'MetodopagamentoController ID',
            'desconto_id' => 'Desconto ID',
            'cupao_id' => 'Cupao ID',
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
     * Gets query for [[Desconto]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDesconto()
    {
        return $this->hasOne(Desconto::class, ['id' => 'desconto_id']);
    }

    /**
     * Gets query for [[Linhafaturas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLinhafaturas()
    {
        return $this->hasMany(Linhafatura::class, ['fatura_id' => 'id']);
    }

    /**
     * Gets query for [[MetodopagamentoController]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMetodopagamento()
    {
        return $this->hasOne(Metodopagamento::class, ['id' => 'metodopagamento_id']);
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

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes); // TODO: Change the autogenerated stub

        //Obter dados do registo em causa
        $id=$this->id;
        $datafatura=$this->datafatura;
        $totalciva=$this->totalciva;
        $subtotal=$this->subtotal;
        $valor_total=$this->valor_total;
        $estado=$this->estado;
        $descontovalor=$this->descontovalor;
        $datapagamento=$this->datapagamento;
        $utilizadorperfil_id=$this->utilizadorperfil_id;
        $metodopagamento_id=$this->metodopagamento_id;
        $desconto_id=$this->desconto_id;
        $cupao_id=$this->cupao_id;

        $myObj=new \stdClass();
        $myObj->id=$id;
        $myObj->datafatura=$datafatura;
        $myObj->totalciva=$totalciva;
        $myObj->subtotal=$subtotal;
        $myObj->valor_total=$valor_total;
        $myObj->estado=$estado;
        $myObj->descontovalor=$descontovalor;
        $myObj->datapagamento=$datapagamento;
        $myObj->utilizadorperfil_id=$utilizadorperfil_id;
        $myObj->metodopagamento_id=$metodopagamento_id;
        $myObj->desconto_id=$desconto_id;
        $myObj->cupao_id=$cupao_id;

        $myJSON = json_encode($myObj);
        if($insert)
            $this->FazPublishNoMosquitto("fatura/insert", "Foi feita uma nova encomenda - " . $myJSON);
        else
            $this->FazPublishNoMosquitto("fatura/update", "Foi alterada uma encomenda" . $myJSON);
    }


    public function afterDelete()
    {
        parent::afterDelete(); // TODO: Change the autogenerated stub

        $prod_id= $this->id;
        $myObj=new \stdClass();
        $myObj->id=$prod_id;
        $myJSON = json_encode($myObj);

        $this->FazPublishNoMosquitto("fatura/delete","Foi eliminada uma fatura" . $myJSON);



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
    }
}
