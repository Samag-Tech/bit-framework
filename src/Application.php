<?php namespace SamagTech\SimpleAppBridge;

use Bref\Event\Handler;
use Dotenv\Dotenv;
use SamagTech\SimpleAppBridge\Exceptions\HandlerNotFoundException;

class Application {

    private ?string $handler = null;

    //-----------------------------------------------------------------------

    /**
     * Costruttore.
     *
     * @param string $env   Path del file .env per caricare l'environment
     */
    public function __construct(string $env) {

        $dotenv = Dotenv::createImmutable($env);
        $dotenv->load();
    }

    //-----------------------------------------------------------------------

    /**
     * Imposta l'handler tramite namespace
     *
     * @param string $handler
     *
     * @return void
     */
    public function setHandler(string $handler) : void {
        $this->handler = $handler;
    }

    //-----------------------------------------------------------------------

    /**
     * Esegue l'hander impostato
     *
     * @return \Bref\Event\Handler
     */
    public function run() : Handler {

        if ( is_null($this->handler) ) {
            throw new HandlerNotFoundException();
        }

        return new $this->handler;
    }

    //-----------------------------------------------------------------------
}