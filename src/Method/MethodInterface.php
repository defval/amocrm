<?php

namespace mb24dev\AmoCRM\Method;

use mb24dev\AmoCRM\ResponseTransformer\ResponseTransformerInterface;
use mb24dev\AmoCRM\User\UserInterface;
use Psr\Http\Message\RequestInterface;

/**
 * Interface MethodInterface
 * @package mb24dev\AmoCRM\Method
 */
interface MethodInterface
{
    /**
     * @return UserInterface
     */
    public function getUser();

    /**
     * @return RequestInterface
     */
    public function buildRequest();

    /**
     * @return ResponseTransformerInterface
     */
    public function getResponseTransformer();
}