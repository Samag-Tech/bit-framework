<?php

use SamagTech\BitFramework\Application;

require __DIR__.'/vendor/autoload.php';

try {

    $app = Application::getInstance(__DIR__);

    $app->bootProviders();

    log_message('info', 'Inizializzazione');

}
catch (Error|Exception $e) {
    log_message('error', $e->getMessage(), ['exception' => $e]);
}


return $app;