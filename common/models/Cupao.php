<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "cupao".
 *
 * @property int $id
 * @property string|null $datavalidade
 * @property int $valor
 * @property int|null $ativo
 * @property string|null $codigo
 *
 * @property Carrinho[] $carrinhos
 * @property Fatura[] $faturas
 */
class Cupao extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cupao';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['datavalidade'], 'safe'],
            [['valor'], 'required'],
            [['valor', 'ativo'], 'integer'],
            [['codigo'], 'string', 'max' => 10],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'datavalidade' => 'Datavalidade',
            'valor' => 'Valor',
            'ativo' => 'Ativo',
            'codigo' => 'Codigo',
        ];
    }

    /**
     * Gets query for [[Carrinhos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCarrinhos()
    {
        return $this->hasMany(Carrinho::class, ['cupao_id' => 'id']);
    }

    /**
     * Gets query for [[Faturas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFaturas()
    {
        return $this->hasMany(Fatura::class, ['cupao_id' => 'id']);
    }
}
