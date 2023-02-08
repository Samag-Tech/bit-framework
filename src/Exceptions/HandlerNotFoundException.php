<?php namespace SamagTech\BitFramework\Exceptions;

use Exception;

/**
 * Eccezione per handler non trovato
 *
 */
class HandlerNotFoundException extends Exception {

    public function __construct($message = 'Handler not found') {
        parent::__construct($message);
    }
}