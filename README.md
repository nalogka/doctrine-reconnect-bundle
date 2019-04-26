Doctrine reconnect
=========================================================
Symfony bundle that checks connection has alive and reconnects if has not.

## Installing

```bash
composer require nalogka/doctrine-reconnect-bundle
```

After that you can set up retries limit and time interval between retries:

```yaml
# file: config/packages/doctrine_reconnect.yaml
doctrine_reconnect:
    max_retries: 12
    wait_before_retry: 333333 # microseconds
```

## Doctrine configuration

Set connection wrapper class provided by Bundle as Doctrine DBAL Wrapper

```yaml
# file: config/packages/doctrine.yaml
doctrine:
    dbal:
        wrapper_class: Nalogka\DoctrineReconnectBundle\DBAL\ConnectionWrapper
```