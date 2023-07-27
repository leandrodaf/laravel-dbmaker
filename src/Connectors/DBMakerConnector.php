<?php

/**
 * Created by syscom.
 * User: syscom
 * Date: 17/06/2019
 * Time: 15:50
 */
namespace DBMaker\ODBC\Connectors;

use PDO;
use Exception;
use DBMaker\ODBC\DBMakerPdo;
use DBMaker\ODBC\DBMakerODBCPdo;
use Illuminate\Database\Connectors\Connector;
use Illuminate\Database\Connectors\ConnectorInterface;

class DBMakerConnector extends Connector implements ConnectorInterface {

    /**
     * Establish a database connection.
     *
     * @param array $config
     *
     * @return PDO
     * @throws Exception
     * @internal param array $options
     *
     */
	public function connect(array $config) {
		$options = $this->getOptions($config);
		$dsn = $this->getDsn($config);
		return $this->createConnection($dsn,$config,$options);
	}

	/**
	 * Create a new PDO connection.
	 *
	 * @param string $dsn
	 * @param array $config
	 * @param array $options
	 * @return DBMakerODBCPdo|DBMakerPdo|PDO
     *
	 * @throws Exception
	 */
	public function createConnection($dsn, array $config, array $options) {
		[$username, $password] = [$config['username'] ?? null, $config['password'] ?? null];
		try {
			return $this->createPdoConnection($dsn, $username, $password, $options);
		} catch (Exception $e) {
			return new DBMakerODBCPdo($dsn, $username, $password, $options);
		}
	}

	/**
	 * Create a new PDO connection instance.
	 *
	 * @param string $dsn
	 * @param string $username
	 * @param string $password
	 * @param array $options
	 * @return PDO
	 */
	protected function createPdoConnection($dsn, $username, $password, $options): PDO {
		return new DBMakerPdo($dsn,$username,$password,$options);
	}
	
	/**
	 * Create a DSN string from a configuration.
	 *
	 * @param array $config        	
	 * @return string
	 */
	protected function getDsn(array $config): string
    {
		extract($config,EXTR_SKIP);
		return $config['dsn'];
	}
}