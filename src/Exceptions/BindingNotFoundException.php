<?php namespace SamagTech\SimpleAppBridge\Exceptions;

use Exception;

/**
 * Eccezione se il bind non esiste
 *
 */
class BindingNotFoundException extends Exception {

    public function __construct($message = 'Binding not found') {
        parent::__construct($message);
    }
}