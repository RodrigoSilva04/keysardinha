<?php
namespace backend\models;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;

    class UploadForm extends Model
{
    /**
     * @var UploadedFile
     */
    public $imageFile;

    public function rules()
    {
        return [
            [['imageFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg'],
        ];
    }

        public function upload($produto)
        {
            if ($this->validate()) {
                // Define o caminho da imagem
                $caminho = Yii::getAlias('@frontend/web/imagensjogos/') . $this->imageFile->baseName . '.' . $this->imageFile->extension;

                // Faz o upload do arquivo
                if ($this->imageFile->saveAs($caminho)) {
                    // Salva o nome da imagem no produto (somente nome do arquivo)
                    $produto->imagem = $this->imageFile->baseName . '.' . $this->imageFile->extension;
                    return true;
                }
            }
            return false;
        }
}