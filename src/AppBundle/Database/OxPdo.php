<?php

/**
 * Created by PhpStorm.
 * User: Tim Klenk
 * Date: 18.10.2016
 * Time: 10:28
 */
namespace AppBundle\Database;

class OxPdo extends BasePdoConnection
{
    protected function getCredentials()
    {
        $credentials = new PdoCredentials();
        $credentials
            ->setHostname('localhost')
            ->setUsername('root')
            ->setPassword('')
            ->setDefaultDatabasename('ox')
            ->setOptions(self::getOptions())
        ;
        return $credentials;
    }

    private static function getOptions()
    {
        return array(
            \PDO::ATTR_PERSISTENT => true,
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
        );
    }
}