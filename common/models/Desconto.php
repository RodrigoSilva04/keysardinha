<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "desconto".
 *
 * @property int $id
 * @property string|null $descricao
 * @property string|null $datainicio
 * @property string|null $datafim
 * @property int|null $ativo
 * @property float|null $desconto
 */
class Desconto extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'desconto';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id', 'ativo'], 'integer'],
            [['datainicio', 'datafim'], 'safe'],
            [['desconto'], 'number'],
            [['descricao'], 'string', 'max' => 255],
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
            'descricao' => 'Descricao',
            'datainicio' => 'Datainicio',
            'datafim' => 'Datafim',
            'ativo' => 'Ativo',
            'desconto' => 'Desconto',
        ];
    }
}
