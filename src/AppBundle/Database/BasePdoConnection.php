<?php
/**
 * Created by PhpStorm.
 * User: Tim Klenk
 * Date: 18.10.2016
 * Time: 12:24
 */

namespace AppBundle\Database;


abstract class BasePdoConnection extends \PDO
{
    public function __construct($databasename = '')
    {
        $credentials = $this->getCredentials();

        if ($databasename == '') {
            $databasename = $credentials->getDefaultDatabasename();
        }

        $this->connectToMysql(
            $credentials->getHostname(),
            $credentials->getUsername(),
            $credentials->getPassword(),
            $databasename,
            $credentials->getOptions()
        );
    }


    abstract protected function getCredentials();

    protected function connectToMysql($hostname, $username, $password, $databasename, array $options)
    {
        parent::__construct(
            'mysql:host=' . $hostname . ';dbname=' . $databasename . ';charset=utf8',
            $username,
            $password,
            $options
        );
    }
}