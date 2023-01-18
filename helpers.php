<?php

//-----------------------------------------------------------------------

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

//-----------------------------------------------------------------------