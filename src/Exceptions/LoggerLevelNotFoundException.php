<?php namespace SamagTech\BitFramework\Exceptions;

use Exception;

/**
 * Eccezione per livello di log non esistente
 *
 */
class LoggerLevelNotFoundException extends Exception {

    public function __construct($message = 'Logger level not found') {
        parent::__construct($message);
    }
}