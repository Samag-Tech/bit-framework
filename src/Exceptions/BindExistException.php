<?php namespace SamagTech\BitFramework\Exceptions;

use Exception;

/**
 * Eccezione se il bind è già presente
 *
 */
class BindExistException extends Exception {

    public function __construct($message = 'Binding already exist') {
        parent::__construct($message);
    }
}