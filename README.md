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

// index.php

<?php

use SamagTech\BitFramework\Application;

require __DIR__.'/vendor/autoload.php';

$app = Application::getInstance(__DIR__);

$app->bootProviders();

try {

    $app->setHandler(ProductHandler::class);

    // $app->register(Provider::class) Funzione per registrare dei provider

    // $app->bootDb() Da utilizzare nel caso di DB

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

## Helpers

Lista degli helpers presenti:

- app() -> Restituisce l'istanza dell'app
- debug() -> Esegue il print_r() della lista dei parametri passati con die() finale
- log_message() -> Scrivere un log