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


    // Método para adicionar aos favoritos
    public static function addFavoritos($utilizadorPerfilId, $produtoId)
    {
        // Verifica se o produto já está nos favoritos
        if (self::find()->where(['utilizadorperfil_id' => $utilizadorPerfilId, 'produto_id' => $produtoId])->exists()) {
            return false; // Já está nos favoritos
        }

        // Cria uma nova entrada para o favorito
        $favorito = new self();
        $favorito->utilizadorperfil_id = $utilizadorPerfilId;
        $favorito->produto_id = $produtoId;
        return $favorito->save(); // Salva no banco de dados
    }

    // Método para remover dos favoritos
    public static function removeFavoritos($utilizadorPerfilId, $produtoId)
    {
        $favorito = self::findOne(['utilizadorperfil_id' => $utilizadorPerfilId, 'produto_id' => $produtoId]);
        if ($favorito) {
            return $favorito->delete(); // Remove o favorito do banco de dados
        }
        return false;
    }

    // Método para verificar se o produto está nos favoritos
    public static function isFavorite($utilizadorPerfilId, $produtoId)
    {
        return self::find()->where(['utilizadorperfil_id' => $utilizadorPerfilId, 'produto_id' => $produtoId])->exists();
    }
}
