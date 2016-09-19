<?php

namespace mb24dev\AmoCRM\ResponseTransformer;

use Psr\Http\Message\ResponseInterface;

/**
 * Class StdObjectResponseTransformer
 * @package mb24dev\AmoCRM\ResponseTransformer
 */
class StdObjectResponseTransformer implements ResponseTransformerInterface
{
    /**
     * @param ResponseInterface $response
     * @return mixed
     */
    public function transform(ResponseInterface $response)
    {
        return json_decode($response->getBody()->getContents());
    }

}