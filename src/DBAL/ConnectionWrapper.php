<?php

namespace Nalogka\DoctrineReconnectBundle\DBAL;

use Doctrine\DBAL\Cache\QueryCacheProfile;
use Doctrine\DBAL\Connection;

class ConnectionWrapper extends Connection
{
    /**
     * @var int Number of retries to make before fail
     */
    private $maxRetries = 12;

    /**
     * @var int Microseconds wait before retry
     */
    private $waitBeforeRetry = 333333;

    /**
     * Set maximum number of retries before throwing an exception
     * 
     * @param int $maxRetries
     * @return ConnectionWrapper
     */
    public function setMaxRetries(int $maxRetries): ConnectionWrapper
    {
        $this->maxRetries = $maxRetries;

        return $this;
    }

    /**
     * Set time (microseconds) to wait before retry
     * 
     * @param int $waitBeforeRetry
     * @return ConnectionWrapper
     */
    public function setWaitBeforeRetry(int $waitBeforeRetry): ConnectionWrapper
    {
        $this->waitBeforeRetry = $waitBeforeRetry;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function executeQuery($query, array $params = [], $types = [], ?QueryCacheProfile $qcp = null)
    {
        return $this->reconnectIfFail(
            function () use ($query, $params, $types, $qcp) {
                return parent::executeQuery($query, $params, $types, $qcp);
            }
        );
    }

    /**
     * @inheritdoc
     */
    public function executeUpdate($query, array $params = [], array $types = [])
    {
        return $this->reconnectIfFail(
            function () use ($query, $params, $types) {
                return parent::executeUpdate($query, $params, $types);
            }
        );
    }

    /**
     * @inheritdoc
     */
    public function query(...$args)
    {
        return $this->reconnectIfFail(
            function () use ($args) {
                return parent::query(...$args);
            }
        );
    }

    /**
     * @inheritdoc
     */
    public function exec($statement)
    {
        return $this->reconnectIfFail(
            function () use ($statement) {
                return parent::exec($statement);
            }
        );
    }

    /**
     * Does an action and reconnects if connection is lost
     */
    public function reconnectIfFail(callable $action)
    {
        $retriesCountdown = $this->maxRetries;
        while ($retriesCountdown--) {
            try {
                return $action();
            } catch (\Doctrine\DBAL\DBALException $e) {
                if (!$e->getPrevious() instanceof \ErrorException && !(
                        $e->getPrevious() instanceof \PDOException 
                        && 2002 /* hostname resolve failure */ === $e->getPrevious()->getCode()
                    )
                ) {
                    break;
                }
                $this->close();
                usleep($this->waitBeforeRetry);
            }
        }

        throw $e;
    }
}
