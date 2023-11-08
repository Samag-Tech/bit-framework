<?php

//-----------------------------------------------------------------------

use Psr\Log\LoggerInterface;
use SamagTech\BitFramework\Application;

if ( ! function_exists('getClassName') ) {

    /**
     * Restituisce il nome della classe in base al namespace
     *
     * @param string $namespace
     *
     * @return string
     */
    function getClassName(string $namespace) : string {
        $explodeNamespace = explode('\\', $namespace);
        return end($explodeNamespace);
    }
}

//-----------------------------------------------------------------------

if ( ! function_exists ('app') ) {

    /**
     * Restituisce l'istanza dell'applicazione
     *
     * @return \SamagTech\BitFramework\Application
     */
    function app() : Application {
        return Application::getInstance();
    }
}

//-----------------------------------------------------------------------

if ( ! function_exists('debug') ) {

    /**
     * Esegue il var dump della lista dei parametri passati
     *
     * @param array ...$d   Lista dati
     *
     * @return void
     */
    function debug(...$d) {
        echo "<pre>";
        var_dump($d);
        echo "</pre>";
        die;
    }
}


if ( ! function_exists('dd') ) {

    /**
     * Esegue il var dump della lista dei parametri passati
     *
     * @param array ...$d   Lista dati
     *
     * @return void
     */
    function dd(...$d) {
        d($d);
        die;
    }
}

//-----------------------------------------------------------------------

if ( ! function_exists('log_message') ) {

    /**
     * Esegue la scrittura dei log
     *
     * @param string $level
     * @param string $message
     * @param array $context    Array chiave-valore che sostituisce i valori nel messagio ES. {value}. Default []
     */
    function log_message(string $level, string $message, array $context = []) {
        app()->make(LoggerInterface::class)->write($level, $message, $context);
    }
}

//-----------------------------------------------------------------------

