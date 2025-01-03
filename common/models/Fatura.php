<?php

namespace common\models;

use Yii;

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
}
