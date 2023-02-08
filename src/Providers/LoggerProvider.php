<?php namespace SamagTech\BitFramework\Providers;

use Psr\Log\LoggerInterface;
use SamagTech\BitFramework\Contracts\Provider;
use SamagTech\BitFramework\Handlers\BrefLogger;

/**
 * Provider per la registrazione del logger
 *
 * @implements \SamagTech\BitFramework\Contracts\Provider
 *
 * @author Alessandro Marotta <alessandro.marotta@samag.tech>
 */
class LoggerProvider implements Provider {

    public function register() : void {
        app()->bind(LoggerInterface::class, new BrefLogger());
    }
}