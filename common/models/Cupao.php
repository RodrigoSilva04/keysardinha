<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "cupao".
 *
 * @property int $id
 * @property string|null $datavalidade
 * @property float|null $desconto
 * @property string|null $descricao
 * @property int|null $ativo
 * @property int|null $pontosnecessarios
 * @property string|null $codigo
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
            [['id'], 'required'],
            [['id', 'ativo', 'pontosnecessarios'], 'integer'],
            [['datavalidade'], 'safe'],
            [['desconto'], 'number'],
            [['descricao'], 'string', 'max' => 100],
            [['codigo'], 'string', 'max' => 10],
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
            'datavalidade' => 'Datavalidade',
            'desconto' => 'Desconto',
            'descricao' => 'Descricao',
            'ativo' => 'Ativo',
            'pontosnecessarios' => 'Pontosnecessarios',
            'codigo' => 'Codigo',
        ];
    }
}
