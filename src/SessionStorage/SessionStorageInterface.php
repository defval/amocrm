<?php

namespace mb24dev\AmoCRM\SessionStorage;

use mb24dev\AmoCRM\Session\Session;
use mb24dev\AmoCRM\Session\SessionDoesNotExistException;
use mb24dev\AmoCRM\Session\SessionDoNotSavedException;
use mb24dev\AmoCRM\User\UserInterface;

/**
 * Interface SessionStorageInterface
 * @package mb24dev\AmoCRM
 */
interface SessionStorageInterface
{
    /**
     * @param Session $session
     * @param UserInterface    $user
     * @throws SessionDoNotSavedException
     */
    public function save(Session $session, UserInterface $user);

    /**
     * @param UserInterface $user
     * @return Session
     * @throws SessionDoesNotExistException
     */
    public function getActive(UserInterface $user);
}