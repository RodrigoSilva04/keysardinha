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
 * @property string|null $estado
 * @property float|null $descontovalor
 * @property int|null $utilizadorperfil_id
 * @property int|null $metodopagamento_id
 * @property int|null $desconto_id
 * @property int|null $chavedigital_id
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
            [['id'], 'required'],
            [['id', 'utilizadorperfil_id', 'metodopagamento_id', 'desconto_id', 'chavedigital_id'], 'integer'],
            [['datafatura'], 'safe'],
            [['totalciva', 'subtotal', 'descontovalor'], 'number'],
            [['estado'], 'string'],
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
            'datafatura' => 'Datafatura',
            'totalciva' => 'Totalciva',
            'subtotal' => 'Subtotal',
            'estado' => 'Estado',
            'descontovalor' => 'Descontovalor',
            'utilizadorperfil_id' => 'Utilizadorperfil ID',
            'metodopagamento_id' => 'Metodopagamento ID',
            'desconto_id' => 'Desconto ID',
            'chavedigital_id' => 'Chavedigital ID',
        ];
    }
}
