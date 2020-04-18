<?php

namespace app\controllers;

use yii\web\Controller;
use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use app\commands\SocketServer;

class SocketController extends Controller
{
    public function actionStart($port = 8080)
    {
        $server = IoServer::factory(
            new HttpServer(
                new WsServer(
                    new SocketServer()
                )
            ),
            $port
        );
        echo "Запускаем сервер для отправки сообщений GeekGram " . PHP_EOL;
        $server->run();
        echo "Сервер работает " . PHP_EOL;
    }
}
