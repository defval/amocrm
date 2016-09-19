<?php

namespace mb24dev\AmoCRM\Session;

/**
 * Class Session
 *
 * @package mb24dev\AmoCRM
 */
class Session implements SessionInterface
{
    private $id;

    /**
     * Session constructor.
     *
     * @param $id
     */
    public function __construct($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }
}