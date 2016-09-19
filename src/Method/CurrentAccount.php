<?php

namespace mb24dev\AmoCRM\Method;

use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\RequestInterface;

/**
 * Class CurrentAccount
 *
 * @package mb24dev\AmoCRM\Method
 */
class CurrentAccount extends BaseMethod
{
    /**
     * @return RequestInterface
     */
    public function buildRequest()
    {
        $request = new Request(
            'GET', $this->user->getAmoCRMDomain() . 'private/api/v2/json/accounts/current'
        );

        return $request;
    }
}
