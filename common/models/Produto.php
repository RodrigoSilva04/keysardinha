<?php

namespace common\models;

use Yii;
use yii\web\UploadedFile;

class Produto extends \yii\db\ActiveRecord
{
    /**
     * @var UploadedFile
     */
    public $uploadImagem;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['descricao'], 'string'],
            [['preco'], 'number'],
            [['datalancamento'], 'safe'],
            [['stockdisponivel', 'categoria_id'], 'integer'],
            [['nome', 'imagem'], 'string', 'max' => 255],
            [['uploadImagem'], 'file', 'maxSize' => 1024 * 1024 * 2], // Tamanho máximo de 2MB
        ];
    }

    /**
     * Upload da imagem
     */
    public function upload()
    {
        if ($this->validate()) {
            if ($this->uploadImagem) {
                $nomeArquivo = $this->uploadImagem->baseName . '.' . $this->uploadImagem->extension; // Nome único para evitar conflitos
                $caminhoCompleto = Yii::getAlias('@frontend/web/imagensjogos/' . $nomeArquivo);

                if ($this->uploadImagem->saveAs($caminhoCompleto)) {
                    $this->imagem = $nomeArquivo; // Salva apenas o nome do arquivo no banco de dados
                    return true;
                }
            }
        }
        return false;

    }
    public function getCategoria()
    {
        return $this->hasOne(Categoria::class, ['id' => 'categoria_id']);
    }
}
