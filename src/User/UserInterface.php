<?php

namespace mb24dev\AmoCRM\User;

use mb24dev\AmoCRM\Session\Session;

/**
 * Interface UserInterface
 * @package mb24dev\AmoCRM
 */
interface UserInterface
{
    /**
     * @return string
     */
    public function getAmoCRMLogin();

    /**
     * @return string
     */
    public function getAmoCRMHash();

    /**
     * @return string
     */
    public function getAmoCRMDomain();

    /**
     * @return Session
     */
    public function getAmoCRMSession();

    /**
     * @param Session $session
     * @return $this
     */
    public function setAmoCRMSession(Session $session);
}