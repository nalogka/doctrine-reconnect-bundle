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
     * @var int Seconds since recently executed query to check connection alive
     *
     * Should be less than the database inactivity timeout.
     * MySQL `wait_timeout` parameter equals to 28800 seconds by default.
     */
    private $healtcheckTimeout = 28000;

    /**
     * @param int $healtcheckTimeout
     */
    public function setHealtcheckTimeout(int $healtcheckTimeout): void
    {
        $this->healtcheckTimeout = $healtcheckTimeout;
    }

    public function executeQuery($query, array $params = [], $types = [], ?QueryCacheProfile $qcp = null)
    {
        $this->checkConnection();

        $this->lastExecuteAt = time();

        return parent::executeQuery($query, $params, $types, $qcp);
    }

    private function checkConnection()
    {
        if ($this->lastExecuteAt == null || time() - $this->lastExecuteAt < $this->healtcheckTimeout) {
            return;
        }

        if ($this->ping() === false) {
            $this->close();
        }
    }
}