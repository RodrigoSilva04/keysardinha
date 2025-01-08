<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "iva".
 *
 * @property int $id
 * @property float $taxa
 * @property string|null $descricao
 * @property int|null $ativo
 *
 * @property Produto[] $produtos
 */
class Iva extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'iva';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['taxa'], 'required'],
            [['taxa'], 'number'],
            [['ativo'], 'integer'],
            [['descricao'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'taxa' => 'Taxa',
            'descricao' => 'Descricao',
            'ativo' => 'Ativo',
        ];
    }

    /**
     * Gets query for [[Produtos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProdutos()
    {
        return $this->hasMany(Produto::class, ['iva_id' => 'id']);
    }
}
