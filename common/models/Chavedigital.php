<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "chavedigital".
 *
 * @property int $id
 * @property string|null $chaveativacao
 * @property string|null $estado
 * @property int|null $produto_id
 * @property string|null $datavenda
 *
 * @property Linhafatura[] $linhafaturas
 * @property Produto $produto
 */
class Chavedigital extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'chavedigital';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['estado'], 'string'],
            [['produto_id'], 'integer'],
            [['datavenda'], 'safe'],
            [['chaveativacao'], 'string', 'max' => 255],
            [['produto_id'], 'exist', 'skipOnError' => true, 'targetClass' => Produto::class, 'targetAttribute' => ['produto_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'chaveativacao' => 'Chaveativacao',
            'estado' => 'Estado',
            'produto_id' => 'Produto ID',
            'datavenda' => 'Datavenda',
        ];
    }

    /**
     * Gets query for [[Linhafaturas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLinhafaturas()
    {
        return $this->hasMany(Linhafatura::class, ['chavedigital_id' => 'id']);
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
