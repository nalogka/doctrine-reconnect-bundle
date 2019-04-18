Doctrine reconnect
=========================================================
Symfony bundle that checks connection has alive and reconnects if has not.

It calls `\Doctrine\DBAL\Connection::ping()` before the actual query would
be executed in condition that previously query has been executed certain time ago.

## Installing

```bash
composer require nalogka/doctrine-reconnect-bundle
```

After that you can set up inactivity timeout (28000 seconds by default):

```yaml
# file: config/packages/doctrine_reconnect.yaml
doctrine_reconnect:
    seconds_between_pings: 28000
```

## Doctrine configuration

Set connection wrapper class provided by Bundle as Doctrine DBAL Wrapper

```yaml
# file: config/packages/doctrine.yaml
doctrine:
    dbal:
        wrapper_class: Nalogka\DoctrineReconnectBundle\DBAL\ConnectionWrapper
```