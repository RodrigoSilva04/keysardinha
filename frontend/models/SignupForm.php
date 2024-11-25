<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\User;
use common\models\Utilizadorperfil;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This email address has already been taken.'],

            ['password', 'required'],
            ['password', 'string', 'min' => Yii::$app->params['user.passwordMinLength']],
        ];
    }

    /**
     * Signs user up.
     *
     * @return bool whether the creating new account was successful and email was sent
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }

        $user = new User();
        $user->username = $this->username;
        $user->email = $this->email;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        $user->generateEmailVerificationToken();

        // if ($this->role == 'cliente')
        // Salva o usuário e verifica se a operação foi bem-sucedida
        if ($user->save()) {
            // Cria um novo registro na tabela utilizador_perfil com o mesmo ID do usuário
            $utilizadorPerfil = new UtilizadorPerfil();
            $utilizadorPerfil->id = $user->id; // Define o mesmo ID do usuário
            $utilizadorPerfil->nome = null; // Supondo que o nome vem do formulário
            $utilizadorPerfil->dataregisto = date('Y-m-d H:i:s'); // Define a data atual como data de registro
            $utilizadorPerfil->pontosacumulados = 0; // Inicia os pontos acumulados como 0
            $utilizadorPerfil->carrinho_id = null; // Define como nulo ou atribua um ID de carrinho, se aplicável

            //Atribui usando o RBAC a role de client
            $auth = Yii::$app->authManager;
            $role = $auth->getRole('client');
            $auth->assign($role, $user->id);

            // Salva o perfil e envia o e-mail de verificação se tudo foi bem-sucedido
            return $utilizadorPerfil->save() && $this->sendEmail($user);
        }

        return null;
    }


    /**
     * Sends confirmation email to user
     * @param User $user user model to with email should be send
     * @return bool whether the email was sent
     */
    protected function sendEmail($user)
    {
        return Yii::$app
            ->mailer
            ->compose(
                ['html' => 'emailVerify-html', 'text' => 'emailVerify-text'],
                ['user' => $user]
            )
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
            ->setTo($this->email)
            ->setSubject('Account registration at ' . Yii::$app->name)
            ->send();
    }
}
