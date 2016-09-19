<?php

namespace mb24dev\AmoCRM\Method;

use mb24dev\AmoCRM\ResponseTransformer\ResponseTransformerInterface;
use mb24dev\AmoCRM\User\UserInterface;

/**
 * Class BaseMethod
 * @package mb24dev\AmoCRM\Method
 */
abstract class BaseMethod implements MethodInterface
{
    /**
     * @var UserInterface
     */
    protected $user;
    /**
     * @var ResponseTransformerInterface
     */
    private $responseTransformer;

    /**
     * BaseMethod constructor.
     * @param UserInterface                $user
     * @param ResponseTransformerInterface $responseTransformer
     */
    public function __construct(UserInterface $user, ResponseTransformerInterface $responseTransformer = null)
    {
        $this->user = $user;
        $this->responseTransformer = $responseTransformer;
    }

    /**
     * @return ResponseTransformerInterface
     */
    public function getResponseTransformer()
    {
        return $this->responseTransformer;
    }

    /**
     * @return UserInterface
     */
    public function getUser()
    {
        return $this->user;
    }
}