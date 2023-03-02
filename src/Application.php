<?php namespace SamagTech\BitFramework;

use Closure;
use Dotenv\Dotenv;
use Bref\Event\Handler;
use Illuminate\Database\Capsule\Manager as DB;
use SamagTech\BitFramework\Contracts\Provider;
use SamagTech\BitFramework\Exceptions\BindExistException;
use SamagTech\BitFramework\Exceptions\BindingNotFoundException;
use SamagTech\BitFramework\Exceptions\HandlerNotFoundException;
use SamagTech\BitFramework\Providers\LoggerProvider;

class Application {

    private static ?self $instance = null;

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
    private static array $container = [];

    /**
     * Path di partenza dell'applicativo
     *
     * @var string
     * @access private
     */
    private ?string $path;

    private array $providers = [
        LoggerProvider::class
    ];

    //-----------------------------------------------------------------------

    /**
     * Costruttore.
     *
     * @param string|null $path   Path di partenza dell'applicativo
     */
    public function __construct(?string $path = null) {
       $this->path = $path;
       $this->loadEnvironment();
    }

    //-----------------------------------------------------------------------

    /**
     * Restituisce l'istanza dell'applicazione
     *
     * @static
     * @param string|null $path  Path di partenza dell'applicativo
     *
     * @return self
     */
    public static function getInstance(?string $path = null) : self {

        if ( is_null(self::$instance)) {
            self::$instance = new static($path);
        }

        return self::$instance;
    }

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

        if ( ! isset(self::$container[$this->handler]) ) {
            return new $this->handler;
        }

        $handler = self::$container[$this->handler];

        if ( $handler instanceof Closure ) {
            return $handler();
        }

        return $handler;

    }

    //-----------------------------------------------------------------------

    /**
     * Restituisce il base path dell'applicativo
     *
     * @access public
     *
     * @return string
     */
    public function basePath() : string {
        return $this->path;
    }

    //-----------------------------------------------------------------------

    /**
     * Restituisce l'istanza della dipendenza
     *
     * @access public
     *
     * @param string $key   Identificativo della dipendenza da recuperare
     *
     * @return mixed
     */
    public function make(string $key) {
        $value = self::getContainer($key);

        if ( $value instanceof Closure) {
            return $value();
        }

        return $value;
    }

    //-----------------------------------------------------------------------

    /**
     * Carica la dipendenza nell'applicazione
     *
     * @access public
     * @param string $key   Identificativo della dipendenza
     * @param mixed $value  Dipendenza da caricare
     *
     * @return void
     */
    public function bind(string $key, $value) : void {
        self::putContainer($key, $value);
    }

    //-----------------------------------------------------------------------

    /**
     * Registra un provider
     *
     * @access public
     *
     * @param \SamagTech\BitFramework\Contracts\Provider $provider  Provider da registrare
     *
     * @return void
     */
    public function register(Provider $provider) : void {
        $provider->register();
    }

    //-----------------------------------------------------------------------

    /**
     * Carica i provider di default dell'applicazione
     *
     * @access public
     *
     * @return void
     */
    public function bootProviders() : void {

        foreach ($this->providers as $provider) {
            $this->register(new $provider);
        }
    }

    //-----------------------------------------------------------------------

    /**
     * Carica l'istanza del DB
     *
     * @return void
     */
    public function bootDb() : void {

        $db = new DB();

        $dbConnections = $this->getDbConnections();

        foreach ($dbConnections as $connectionName =>  $dbConnection ) {
            $db->addConnection($dbConnection, $connectionName);
        }

        $db->bootEloquent();

    }

    //-----------------------------------------------------------------------

    /**
     * Recupera tutte le connessioni al DB
     *
     * @access private
     *
     * @return array
     */
    private function getDbConnections() : array {

        // Conterrà tutte le connessioni
        $connections = [];

        // Se l'ambiente è di test allora creo la configurazione di test
        if ( env('ENV') == 'testing') {
            $connections[] =
                [
                    'testing' => [
                        'driver'    => env('DB_TEST_DRIVER', 'sqlite'),
                        'host'      => env('DB_TEST_HOST', ''),
                        'database'  => env('DB_TEST_NAME'),
                        'username'  => env('DB_TEST_USER'),
                        'password'  => env('DB_TEST_PASSWORD'),
                        'charset'   => 'utf8',
                        'collation' => 'utf8_unicode_ci',
                        'prefix'    => env('DB_TEST_PREFIX', ''),
                        'port'      => env('DB_TEST_PORT', '3306'),
                    ]
                ];

        }

        // Se presente il file delle configurazioni lo utilizzo
        // altrimenti utilizzo la configurazione di default
        if ( file_exists($this->path.'/config/database.php') ) {
            $connections = require $this->path.'/config/database.php';
        } else {

            $connections[] = [
                'default'   => [
                    'driver'    => env('DB_TEST_DRIVER', 'sqlite'),
                    'host'      => env('DB_TEST_HOST', ''),
                    'database'  => env('DB_TEST_NAME'),
                    'username'  => env('DB_TEST_USER'),
                    'password'  => env('DB_TEST_PASSWORD'),
                    'charset'   => 'utf8',
                    'collation' => 'utf8_unicode_ci',
                    'prefix'    => env('DB_TEST_PREFIX', ''),
                    'port'      => env('DB_TEST_PORT', '3306'),
                ]
            ];
        }


        return $connections;
    }

    //-----------------------------------------------------------------------

    /**
     * Restituisce i dati presenti nel container
     *
     * @access private
     * @static
     * @param string $key   Chiave per accedere all'oggetto.
     *
     * @return mixed
     */
    private static function getContainer(string $key) : mixed {

        if ( ! isset(self::$container[$key]) ) {
            throw new BindingNotFoundException();
        }

        return self::$container[$key];
    }

    //-----------------------------------------------------------------------

    /**
     * Immette nel container un nuovo valore
     *
     * @access private
     * @static
     *
     * @param string $key   Chiave con cui salvare il valore
     * @param mixed $value  Valore da associare alla chiave
     *
     * @return void
     */
    private static function putContainer(string $key, $value) : void {

        if ( isset(self::$container[$key]) ) {
            throw new BindExistException();
        }

        self::$container[$key] = $value;
    }

    //-----------------------------------------------------------------------

    /**
     * Carica l'ambiente dal .env
     *
     * @access private
     *
     * @return void
     */
    private function loadEnvironment() : void {

        if ( ! is_null($this->path) ) {
            $dotenv = Dotenv::createImmutable($this->path);
            $dotenv->load();
        }
    }

    //-----------------------------------------------------------------------

}