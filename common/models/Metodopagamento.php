<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "metodopagamento".
 *
 * @property int $id
 * @property string|null $nomemetodopagamento
 * @property string|null $descricao
 */
class Metodopagamento extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'metodopagamento';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['descricao'], 'string'],
            [['nomemetodopagamento'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nomemetodopagamento' => 'Nomemetodopagamento',
            'descricao' => 'Descricao',
        ];
    }
}
