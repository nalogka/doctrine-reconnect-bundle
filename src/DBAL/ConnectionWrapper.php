<?php

namespace Nalogka\DoctrineReconnectBundle\DBAL;

use Doctrine\DBAL\Cache\QueryCacheProfile;
use Doctrine\DBAL\Connection;

class ConnectionWrapper extends Connection
{
    /**
     * @var int Last query executed time
     */
    private $lastExecuteAt = null;

    /**
     * @var int Time in seconds between database connection checks
     *
     * Need to set the time between pings less than the database timeout.
     * MySQL wait_timeout parameter is 28800 seconds by default.
     */
    private $secondsBetweenPings = 28000;

    /**
     * @param int $secondsBetweenPings
     */
    public function setSecondsBetweenPings(int $secondsBetweenPings): void
    {
        $this->secondsBetweenPings = $secondsBetweenPings;
    }

    public function executeQuery($query, array $params = [], $types = [], ?QueryCacheProfile $qcp = null)
    {
        $this->checkConnection();

        $this->lastExecuteAt = time();

        return parent::executeQuery($query, $params, $types, $qcp);
    }

    private function checkConnection()
    {
        if ($this->lastExecuteAt == null || time() - $this->lastExecuteAt < $this->secondsBetweenPings) {
            return;
        }

        if ($this->ping() === false) {
            $this->close();
        }
    }
}