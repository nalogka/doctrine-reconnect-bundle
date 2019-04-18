Doctrine reconnect
=========================================================
Symfony bundle that calls the `\Doctrine\DBAL\Connection::ping` if enough time has passed since the last executed query to the database.

## Installing

```bash
composer require nalogka/doctrine-reconnect-bundle
```

After that you can set up time between database pings (28000 seconds by default):

```yaml
# file: config/packages/doctrine_reconnect.yaml
doctrine_reconnect:
    healthcheck_timeout: 28000
```

## Doctrine configuration

Set bundle wrapper class as Doctrine DBAL Wrapper

```yaml
# file: config/packages/doctrine.yaml
doctrine:
    dbal:
        wrapper_class: Nalogka\DoctrineReconnectBundle\DBAL\ConnectionWrapper
```