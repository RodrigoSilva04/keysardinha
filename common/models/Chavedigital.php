<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "chavedigital".
 *
 * @property int $id
 * @property string|null $chaveativacao
 * @property string|null $estado
 * @property int|null $produto_id
 * @property string|null $datavenda
 */
class Chavedigital extends \yii\db\ActiveRecord
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

    public function getProduto()
    {
        return $this->hasOne(Produto::className(), ['id' => 'produto_id']);
    }
}
