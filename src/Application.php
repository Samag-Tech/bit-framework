<?php namespace SamagTech\SimpleAppBridge;

use Bref\Event\Handler;
use Dotenv\Dotenv;
use SamagTech\SimpleAppBridge\Exceptions\BindingNotFoundException;
use SamagTech\SimpleAppBridge\Exceptions\HandlerNotFoundException;

class Application {

    /**
     * Namespace handler da eseguire
     *
     * @var string
     *
     *  @access private
     *
     */
    private ?string $handler = null;

    /**
     * Container di oggetti, valori e funzioni
     * da poter utilizzare nell'applicativo
     *
     * @var array<string,mixed>
     *
     * @access private
     */
    private static $container = [];

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

    /**
     * Restituisce i dati presenti nel container
     *
     * @param string $key   Chiave per accedere all'oggetto.
     *
     * @return mixed
     */
    public static function getObject(string $key) : mixed {

        if ( ! isset(self::$container[$key]) ) {
            throw new BindingNotFoundException();
        }

        return self::$container[$key];
    }

    //-----------------------------------------------------------------------
}