<?php

use SamagTech\BitFramework\Application;

require __DIR__.'/vendor/autoload.php';

$app = Application::getInstance(__DIR__);

$app->bootProviders();

try {

    $app->setHandler(ProductHandler::class);

    return $app->run();

}
catch (Error|Exception $e) {
    log_message('error', $e->getMessage(), ['exception' => $e]);
}