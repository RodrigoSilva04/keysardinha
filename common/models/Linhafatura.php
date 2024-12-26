<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "linhafatura".
 *
 * @property int $id
 * @property int|null $quantidade
 * @property float|null $precounitario
 * @property float|null $subtotal
 * @property int|null $fatura_id
 * @property int|null $desconto_id
 * @property int|null $produto_id
 * @property int|null $iva_id
 * @property int|null $chavedigital_id
 *
 * @property Chavedigital $chavedigital
 * @property Desconto $desconto
 * @property Fatura $fatura
 * @property Iva $iva
 * @property Produto $produto
 */
class Linhafatura extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'linhafatura';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['quantidade', 'fatura_id', 'desconto_id', 'produto_id', 'iva_id', 'chavedigital_id'], 'integer'],
            [['precounitario', 'subtotal'], 'number'],
            [['fatura_id'], 'exist', 'skipOnError' => true, 'targetClass' => Fatura::class, 'targetAttribute' => ['fatura_id' => 'id']],
            [['iva_id'], 'exist', 'skipOnError' => true, 'targetClass' => Iva::class, 'targetAttribute' => ['iva_id' => 'id']],
            [['produto_id'], 'exist', 'skipOnError' => true, 'targetClass' => Produto::class, 'targetAttribute' => ['produto_id' => 'id']],
            [['desconto_id'], 'exist', 'skipOnError' => true, 'targetClass' => Desconto::class, 'targetAttribute' => ['desconto_id' => 'id']],
            [['chavedigital_id'], 'exist', 'skipOnError' => true, 'targetClass' => Chavedigital::class, 'targetAttribute' => ['chavedigital_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'quantidade' => 'Quantidade',
            'precounitario' => 'Precounitario',
            'subtotal' => 'Subtotal',
            'fatura_id' => 'Fatura ID',
            'desconto_id' => 'Desconto ID',
            'produto_id' => 'Produto ID',
            'iva_id' => 'Iva ID',
            'chavedigital_id' => 'Chavedigital ID',
        ];
    }

    /**
     * Gets query for [[Chavedigital]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getChavedigital()
    {
        return $this->hasOne(Chavedigital::class, ['id' => 'chavedigital_id']);
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
     * Gets query for [[Fatura]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFatura()
    {
        return $this->hasOne(Fatura::class, ['id' => 'fatura_id']);
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
     * Gets query for [[Produto]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProduto()
    {
        return $this->hasOne(Produto::class, ['id' => 'produto_id']);
    }
}
