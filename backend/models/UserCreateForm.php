<?php
namespace backend\models;

use Yii;
use yii\base\Model;
use common\models\User;
use common\models\Utilizadorperfil;

/**
 * Formulário para criar utilizadores no backend
 */
class UserCreateForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $role;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'Este nome de utilizador já está em uso.'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'Este e-mail já está em uso.'],

            ['password', 'required'],
            ['password', 'string', 'min' => Yii::$app->params['user.passwordMinLength']],

            ['role', 'required'],
            ['role', 'in', 'range' => array_keys(Yii::$app->authManager->getRoles())],
        ];
    }

    /**
     * Cria um novo utilizador.
     *
     * @return bool|null
     */
    public function createUser()
    {
        if (!$this->validate()) {
            return null;
        }

        $user = new User();
        $user->username = $this->username;
        $user->email = $this->email;
        $user->setPassword($this->password);
        $user->generateAuthKey();

        if ($user->save()) {
            // Adiciona o perfil do utilizador
            $utilizadorPerfil = new Utilizadorperfil();
            $utilizadorPerfil->id = $user->id;
            $utilizadorPerfil->nome = null;
            $utilizadorPerfil->dataregisto = date('Y-m-d H:i:s');
            $utilizadorPerfil->pontosacumulados = 0;
            $utilizadorPerfil->carrinho_id = null;

            // Associa o papel (role) ao usuário
            if ($this->role) {
                $auth = Yii::$app->authManager;
                $role = $auth->getRole($this->role); // Obtém a role do RBAC
                if ($role) {
                    $auth->assign($role, $user->id);
                }
            }

            return $utilizadorPerfil->save();
        }

        return null;
    }
}