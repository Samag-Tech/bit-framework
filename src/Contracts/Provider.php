<?php namespace SamagTech\BitFramework\Contracts;

/**
 * Interfaccia per la definizione di un provider.
 *
 * Un Provider è una classe che registra dipendenze nell'applicazione
 * successivamente richiamabili tramite la funzione make() della
 * classe Application.
 *
 * @interface
 *
 * @author Alessandro Marotta <alessandro.marotta@samag.tech>
 */
interface Provider {

    //-----------------------------------------------------------------------

    /**
     * Definisce la registrazione delle dipendenze tramite la funzione
     * bind() dell'applicazione
     *
     * @access public
     *
     * @return void
     */
    public function register() : void;
}