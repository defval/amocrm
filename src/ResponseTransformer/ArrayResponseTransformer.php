<?php

namespace mb24dev\AmoCRM\ResponseTransformer;

use Psr\Http\Message\ResponseInterface;

/**
 * Class ArrayJsonTransformer
 *
 * @package mb24dev\AmoCRM\ResponseTransformer
 */
class ArrayResponseTransformer implements ResponseTransformerInterface
{
    /**
     * @param ResponseInterface $response
     * @return string
     */
    public function transform(ResponseInterface $response)
    {
        return json_decode($response->getBody()->getContents(), true);
    }

}
