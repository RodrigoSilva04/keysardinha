<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "favoritos".
 *
 * @property int $id
 * @property int $utilizadorperfil_id
 * @property int $produto_id
 */
class Favoritos extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'favoritos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['utilizadorperfil_id', 'produto_id'], 'required'],
            [['utilizadorperfil_id', 'produto_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'utilizadorperfil_id' => 'Utilizadorperfil ID',
            'produto_id' => 'Produto ID',
        ];
    }
}
