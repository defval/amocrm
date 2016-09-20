<?php

namespace mb24dev\AmoCRM\HttpClient;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Interface ClientInterface
 *
 * @package mb24dev\AmoCRM
 */
interface HttpClientInterface
{
    /**
     * Send an HTTP request.
     *
     * @param RequestInterface $request Request to send
     * @param array            $options Request options to apply to the given
     *                                  request and to the transfer.
     *
     * @return ResponseInterface
     * @throws \Exception
     */
    public function send(RequestInterface $request, array $options = []);
}
