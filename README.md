# Bit Framework

Micro-framework per la gestione di piccole funzione lambda tramite il [Serverless Framekwork](https://serverless.com/) e [Bref](https://bref.sh).

## Installazione

L'installazione avviene tramite il comando

```bash
    composer require samagtech/bit-framework
```

## Quick Start

La prima cosa da fare è creare il file <b>Handler</b> per l'esecuzione dello script tramite Bref. Esempio:

```php

<?php

require __DIR__ . '/vendor/autoload.php';

use Bref\Context\Context;

class Handler implements \Bref\Event\Handler
{
    public function handle($event, Context $context)
    {
        return 'Hello ' . $event['name'];
    }
}

```

Successivamente deve essere creata l'applicazione di Bit

```php

// bootstrap.php

<?php

use SamagTech\BitFramework\Application;

require __DIR__.'/vendor/autoload.php';

$app = Application::getInstance(__DIR__);

$app->bootProviders();

// $app->register(Provider::class) Funzione per registrare dei provider

// $app->bootDb() Da utilizzare nel caso di DB

return $app;

```

ed infine, deve essere creato il punto di avvio dell'applicazione

```php
// index.php

try {

    $app = require __DIR__.'/bootstrap.php'

    $app->setHandler(ProductHandler::class);

    return $app->run();

}
catch (Error|Exception $e) {

    log_message('error', $e->getMessage(), ['exception' => $e]);
}

```

## Creazione di un provider

Per creare un provider bisogna creare una classe che implementa <b>\SamagTech\BitFramework\Contracts\Provider<b>. Esempio.

```php
// FooProvider.php

class FooProvider implements \SamagTech\BitFramework\Contracts\Provider {

    public function register () : void {

        app()->bind(Foo::class, new Foo());

        // Or

        app()->bind(Foo::class, function () {
            return new Foo();
        })
    }
}

```

## Creazione dei modelli

Per la gestione del database è possibile utilizzare i modelli di [Laravel](https://laravel.com/docs/9.x/eloquent).

```php
class Foo extends Illuminate\Database\Eloquent\Model {}
```

## Environment

Le seguenti variabili servono per configurare un ambiente:

```text

<!-- Configurazione per il DB -->
DB_DRIVER=mysql
DB_HOST=
DB_NAME=
DB_USER=
DB_PASSWORD=
DB_PREFIX=

<!-- Configura la tipologia di ambiente -->
ENV=local

<!-- Attiva/Disattiva il debug -->
DEBUG=true

```
## Configurazioni DB

Per aggiungere più connessione al DB deve essere creato il file config/database.php con il seguente contenuto

```php

<?php

return [
    'default'   => [
        'driver'    => env('DB_DRIVER', 'mysql'),
        'host'      => env('DB_HOST', '127.0.0.1'),
        'database'  => env('DB_NAME', ''),
        'username'  => env('DB_USER', ''),
        'password'  => env('DB_PASSWORD', ''),
        'charset'   => 'utf8',
        'collation' => 'utf8_unicode_ci',
        'prefix'    => env('DB_PREFIX', ''),
        'port'      => env('DB_PORT', '3306'),
    ]

];

```

## Helpers

Lista degli helpers presenti:

- app() -> Restituisce l'istanza dell'app
- debug() -> Esegue il print_r() della lista dei parametri passati con die() finale
- d() -> Debug con kint
- dd() -> Debug con kint più die()
- log_message() -> Scrivere un log