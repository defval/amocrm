<?php

namespace mb24dev\AmoCRM\User;

use mb24dev\AmoCRM\Session\Session;

/**
 * Class AmoCRM
 * @package mb24dev\AmoCRM
 */
class User implements UserInterface
{
    /**
     * @var string
     */
    private $login;

    /**
     * @var string
     */
    private $hash;

    /**
     * @var string
     */
    private $domain;

    /**
     * @var Session
     */
    private $session;

    /**
     * AmoCRMUser constructor.
     * @param                         $domain
     * @param                         $login
     * @param                         $hash
     */
    public function __construct($domain, $login, $hash)
    {
        $this->domain = $domain;
        $this->login = $login;
        $this->hash = $hash;
    }

    /**
     * @return string
     */
    public function getAmoCRMLogin()
    {
        return $this->login;
    }

    /**
     * @return string
     */
    public function getAmoCRMHash()
    {
        return $this->hash;
    }

    /**
     * @return string
     */
    public function getAmoCRMDomain()
    {
        return $this->domain;
    }

    /**
     * @return Session
     */
    public function getAmoCRMSession()
    {
        return $this->session;
    }

    /**
     * @param Session $session
     * @return $this
     */
    public function setAmoCRMSession(Session $session)
    {
        $this->session = $session;

        return $this;
    }
}