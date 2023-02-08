<?php namespace SamagTech\BitFramework;

/**
 * Classe astratta per la definizione di una configurazione
 *
 * @abstract
 */
abstract class Config {

    //-----------------------------------------------------------------------

    /**
     * Costruttore.
     *
     * Precarica le configurazioni
     */
    public function __construct() {
        $this->preload();
    }

    //-----------------------------------------------------------------------

    /**
     * Precarica gli attributi della classe direttamente
     * dal file .env.
     *
     * Es. Se ho una classe TestConfig con un attributo $text
     * e nel file .env ho un valore test.text="prova" allora in automatico
     * la classe TestConfig avrà l'attributo impostato a "prova"
     *
     * @access private
     *
     * @return void
     */
    private function preload() : void {

        $vars = array_keys(get_object_vars($this));

        $class = getClassName($this::class);

        // Utizzo il nome in minuscolo della classe senza il suffisso config
        $class = strtolower(str_replace('Config', '', $class));

        foreach ($vars as $var) {

            $value = env($class.'.'.$var);

            if ( is_null($value) ) continue;

            $this->{$var} = $value;
        }
    }

    //-----------------------------------------------------------------------

}