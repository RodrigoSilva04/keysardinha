<?php

namespace backend\controllers;

use PhpMqtt\Client\ConnectionSettings;
use PhpMqtt\Client\MqttClient;
use Yii;

class NotificacoesController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionPublish($mensagem)
    {
        $server = 'localhost'; // Endereço do Mosquitto
        $port = 1883; // Porta MQTT
        $clientId = 'yii2-backend-publisher';
        $topic = 'notificacoes/site';

        try {
            $mqtt = new MqttClient($server, $port, $clientId);
            $settings = (new ConnectionSettings())->setKeepAliveInterval(60);

            $mqtt->connect($settings);
            $mqtt->publish($topic, $mensagem, 0);
            $mqtt->disconnect();

            return $this->asJson(['success' => true, 'message' => 'Notificação publicada com sucesso!']);
        } catch (\Exception $e) {
            Yii::error($e->getMessage(), __METHOD__);
            return $this->asJson(['success' => false, 'message' => 'Erro ao publicar notificação.']);
        }
    }

    public function actionSubscribe($topic)
    {
        $server = 'localhost'; // Endereço do Mosquitto
        $port = 1883; // Porta MQTT
        $clientId = 'yii2-backend-subscriber';

        try {
            // Crie o cliente MQTT
            $mqtt = new MqttClient($server, $port, $clientId);
            $settings = (new ConnectionSettings())
                ->setKeepAliveInterval(60);

            // Conecte-se ao broker
            $mqtt->connect($settings);

            // Inscreva-se no tópico
            $mqtt->subscribe($topic, function (string $topic, string $message) {
                // Processar a mensagem recebida
                Yii::info("Recebida mensagem no tópico {$topic}: {$message}", __METHOD__);

                // Exemplo: Enviar notificação para o frontend via WebSocket ou salvar no banco
            }, 0);

            // Inicia o loop para processar as mensagens
            $mqtt->loop(true); // `true` para rodar o loop indefinidamente
            $mqtt->disconnect();

            return $this->asJson(['success' => true, 'message' => 'Subscrito com sucesso no tópico.']);
        } catch (\Exception $e) {
            Yii::error($e->getMessage(), __METHOD__);
            return $this->asJson(['success' => false, 'message' => 'Erro ao subscrever no tópico.']);
        }
    }


}
