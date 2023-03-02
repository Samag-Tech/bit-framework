<?php namespace SamagTech\BitFramework\Support;

use PHPUnit\Framework\TestCase;
use SamagTech\BitFramework\Application;

/**
 * Classe per la gestione dei test
 *
 * @extends \PHPUnit\Framework\TestCase
 */
abstract class Tests extends TestCase {

    /**
     * Istanza dell'applicazione
     *
     * @var ]\SamagTech\BitFramework\Application
     *
     * @access protected
     */
    protected ?Application $app;

    //-----------------------------------------------------------------------

    /**
     * Ad ogni test esegue il refresh dell'applicazione
     *
     */
    protected function setUp(): void {
        parent::setUp();

        $this->refreshApplication();
    }

    //-----------------------------------------------------------------------

    /**
     * Crea l'applicazione
     *
     * @access protected
     *
     * @return \SamagTech\BitFramework\Application
     */
    protected function createApplication() : Application {
        return require __DIR__.'/../bootstrap.php';
    }

    //-----------------------------------------------------------------------

    /**
     * Esegue il refresh dell'applicazione
     *
     * @access protected
     *
     * @return void
     */
    private function refreshApplication() : void {

        if ( is_null($this->app) ) {
            $this->app = Application::getInstance();
        }

        $this->app->clearInstance();

        $this->app = $this->createApplication();
    }

    //-----------------------------------------------------------------------
}

