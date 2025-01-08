<?php
Yii::setAlias('@common', dirname(__DIR__));
Yii::setAlias('@frontend', dirname(dirname(__DIR__)) . '/frontend');
Yii::setAlias('@backend', dirname(dirname(__DIR__)) . '/backend');
Yii::setAlias('@console', dirname(dirname(__DIR__)) . '/console');

Yii::setAlias('@web', 'http://projeto/frontend/web/site/index'); // Substitua pela URL desejada
Yii::setAlias('@webroot', dirname(dirname(__DIR__)) . '/frontend/web/site/index'); // Caminho físico correspondente