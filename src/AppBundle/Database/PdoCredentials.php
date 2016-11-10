<?php
/**
 * Created by PhpStorm.
 * User: Tim Klenk
 * Date: 18.10.2016
 * Time: 12:17
 */

namespace AppBundle\Database;


class PdoCredentials
{
    private $hostname;
    private $username;
    private $password;
    private $defaultDatabasename;
    private $options;

    public function getHostname()
    {
        return $this->hostname;
    }

    public function getDefaultDatabasename()
    {
        return $this->defaultDatabasename;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getOptions()
    {
        return $this->options;
    }


    public function setDefaultDatabasename($defaultDatabasename)
    {
        $this->defaultDatabasename = $defaultDatabasename;
        return $this;
    }


    public function setHostname($hostname)
    {
        $this->hostname = $hostname;
        return $this;
    }


    public function setOptions($options)
    {
        $this->options = $options;
        return $this;
    }


    public function setPassword($password)
    {
        $this->password = $password;
        return $this;
    }


    public function setUsername($username)
    {
        $this->username = $username;
        return $this;
    }
}