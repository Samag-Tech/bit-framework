<?php

use SamagTech\BitFramework\Application;

require __DIR__.'/vendor/autoload.php';

try {

    $app = Application::getInstance(__DIR__);

    log_message('info', 'Inizializzazione');

    $app->bootProviders();

    log_message('info', 'Caricamento provider');

}
catch (Error|Exception $e) {
    log_message('error', $e->getMessage(), ['exception' => $e]);
}


return $app;