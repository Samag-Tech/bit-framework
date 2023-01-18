<?php namespace SamagTech\SimpleAppBridge;

use Dotenv\Dotenv;

class Application {

    public function __construct(string $env) {

        $dotenv = Dotenv::createImmutable($env);
        $dotenv->load();
    }
}