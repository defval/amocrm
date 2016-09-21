<?php

namespace mb24dev\AmoCRM\SessionStorage;

use mb24dev\AmoCRM\Session\Session;
use mb24dev\AmoCRM\Session\SessionDoesNotExistException;
use mb24dev\AmoCRM\Session\SessionDoNotSavedException;
use mb24dev\AmoCRM\User\UserInterface;

/**
 * Class FileSessionStorage
 *
 * @package mb24dev\AmoCRM\Session
 */
class FileSessionStorage implements SessionStorageInterface
{
    /**
     * @var string
     */
    private $sessionPath;

    /**
     * FileSessionStorage constructor.
     *
     * @param $sessionPath
     */
    public function __construct($sessionPath)
    {
        $this->sessionPath = $sessionPath;
    }

    /**
     * @param Session       $session
     * @param UserInterface $user
     * @throws SessionDoNotSavedException
     */
    public function save(Session $session, UserInterface $user)
    {
        $filename = $this->sessionPath . $user->getAmoCRMLogin();
        if (is_dir($this->sessionPath)) {
            if (file_put_contents($filename, $session->getId())) {
                return;
            }
        }

        throw new SessionDoNotSavedException();
    }

    /**
     * @param UserInterface $user
     * @return Session
     * @throws SessionDoesNotExistException
     */
    public function getActive(UserInterface $user)
    {
        $filename = $this->sessionPath . $user->getAmoCRMLogin();
        if (file_exists($filename)) {
            $fileUpdatedDate = new \DateTime(date("F d Y H:i:s.", filemtime($filename)));
            $currentDate = new \DateTime();
            $diff = $currentDate->diff($fileUpdatedDate);
            $diffMinutes = $diff->d * 24 * 60;
            $diffMinutes += $diff->h * 60;

            if ($diffMinutes < 15 && $data = file_get_contents($filename)) {
                return new Session($data);
            }
        }

        throw new SessionDoesNotExistException($user);
    }
}
