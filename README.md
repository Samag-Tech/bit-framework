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
require __DIR__ . '/vendor/autoload.php';

$app = __DIR__.'/vendor/samagtech/bit-framework/bootstrap.php';

// $app->register(Provider::class) Funzione per registrare dei provider

// $app->bootDb() Da utilizzare nel caso di DB

$app->setHandler(Handler::class);   // Impostazione Handler da utilizzare

return $app->run();

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

## Helpers

Lista degli helpers presenti:

- app() -> Restituisce l'istanza dell'app
- debug() -> Esegue il print_r() della lista dei parametri passati con die() finale
- log_message() -> Scrivere un log