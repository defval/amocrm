<?php

namespace mb24dev\AmoCRM\ResponseTransformer;

use Psr\Http\Message\ResponseInterface;

/**
 * Interface DataMapper
 * @package mb24dev\AmoCRM
 */
interface ResponseTransformerInterface
{
    /**
     * @param ResponseInterface $response
     * @return mixed
     * @throws ResponseTransformException
     */
    public function transform(ResponseInterface $response);
}