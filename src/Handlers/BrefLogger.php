<?php namespace SamagTech\BitFramework\Handlers;

use Bref\Logger\StderrLogger;
use Psr\Log\LogLevel;
use SamagTech\BitFramework\Exceptions\LoggerLevelNotFoundException;

/**
 * Classe per la gestione dei log con classe di Bref
 *
 * @author Alessandro Marotta <alessandro.marotta@samag.tech>
 */
class BrefLogger {

    /**
     * Logger
     *
     * @access private
     *
     * @var \Bref\Logger\StderrLogger
     */
    private StderrLogger $logger;

    //-----------------------------------------------------------------------

    /**
     * Costruttore.
     *
     */
    public function __construct() {

        /**
         * Se l'ambiente non è 'local' allora scrivo sullo standard error
         * altrimenti creo i file fisici
         */
        if ( ! env('ENV', 'local') ) {
            $stream = 'php://stderr';
        }
        else {

            $logDir = $this->getLogDir();

            if ( ! file_exists($logDir) ) {
                $this->createLogDir($logDir);
            }

            $stream = $this->createFile();
        }

        // Imposto il logger
        $this->logger = new StderrLogger(LogLevel::DEBUG, $stream);
    }

    //-----------------------------------------------------------------------

    /**
     * Funzione che scrive i log
     *
     * @access public
     *
     * @param string $level     Livello del log [debug, info, warning, error]
     * @param string $message   Messaggio del log
     * @param array $context
     *
     * @return void
     */
    public function write(string $level, string $message, array $context = []) : void {

        if ( ! in_array($level, ['debug', 'info', 'warning', 'error']) ) {
            throw new LoggerLevelNotFoundException();
        }

        // Aggiungo la data di scrittura al messaggio
        $message = date('Y-m-d H:i:s') . ' ' .  $message;

        $this->logger->{$level}($message, $context);
    }

    //-----------------------------------------------------------------------

    /**
     * Crea il file dei log
     *
     * @access private
     *
     * @return string   Path del file
     */
    private function createFile () : string {

        $filename = $this->getLogDir().DIRECTORY_SEPARATOR.'/log-'.date('Y-m-d').'.log';

        if ( ! file_exists($filename) ) {
            $fp = fopen($filename, 'w');
            fclose($fp);
        }

        return $filename;

    }

    //-----------------------------------------------------------------------

    /**
     * Restituisce la directory dei logs
     *
     * @access private
     *
     * @return string
     */
    private function getLogDir() : string {
        return app()->basePath().'/logs';
    }

    //-----------------------------------------------------------------------

    /**
     * Crea la directory dei log
     *
     * @access private
     *
     * @param string $dir   Path della directory
     *
     * @return void
     */
    private function createLogDir(string $dir) : void {

        if ( ! file_exists($dir) ) {
            mkdir($dir, 0777);
        }
    }

    //-----------------------------------------------------------------------
}