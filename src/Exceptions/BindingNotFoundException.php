<?php namespace SamagTech\BitFramework\Exceptions;

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