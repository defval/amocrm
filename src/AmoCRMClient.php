<?php

namespace mb24dev\AmoCRM;

use Dflydev\FigCookies\Cookie;
use Dflydev\FigCookies\FigRequestCookies;
use Dflydev\FigCookies\SetCookies;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Psr7\Request;
use mb24dev\AmoCRM\Method\MethodInterface;
use mb24dev\AmoCRM\ResponseTransformer\ResponseTransformerInterface;
use mb24dev\AmoCRM\Session\Session;
use mb24dev\AmoCRM\Session\SessionDoesNotExistException;
use mb24dev\AmoCRM\SessionStorage\SessionStorageInterface;
use mb24dev\AmoCRM\User\UserInterface;
use Psr\Log\LoggerInterface;

/**
 * Class AmoCRM
 *
 * @package mb24dev\AmoCRM
 */
class AmoCRMClient
{
    /**
     * @var ClientInterface
     */
    private $httpClient;

    /**
     * @var SessionStorageInterface
     */
    private $sessionStorage;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var ResponseTransformerInterface
     */
    private $responseTransformer;

    /**
     * AmoCRM constructor.
     *
     * @param ClientInterface              $httpClient
     * @param SessionStorageInterface      $sessionStorage
     * @param ResponseTransformerInterface $responseTransformer
     * @param LoggerInterface              $logger
     */
    public function __construct(
        ClientInterface $httpClient,
        SessionStorageInterface $sessionStorage,
        ResponseTransformerInterface $responseTransformer,
        LoggerInterface $logger = null
    ) {
        $this->httpClient = $httpClient;
        $this->responseTransformer = $responseTransformer;
        $this->sessionStorage = $sessionStorage;
        $this->logger = $logger;
    }

    /**
     * @param ClientInterface $httpClient
     */
    public function setHttpClient($httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * @param SessionStorageInterface $sessionStorage
     */
    public function setSessionStorage($sessionStorage)
    {
        $this->sessionStorage = $sessionStorage;
    }

    /**
     * @param ResponseTransformerInterface $responseTransformer
     */
    public function setResponseTransformer($responseTransformer)
    {
        $this->responseTransformer = $responseTransformer;
    }

    /**
     * @param LoggerInterface $logger
     */
    public function setLogger($logger)
    {
        $this->logger = $logger;
    }

    /**
     * @param MethodInterface $method
     * @return mixed
     * @throws Exception
     */
    public function exec(MethodInterface $method)
    {
        try {
            $request = $method->buildRequest();

            if (!$session = $method->getUser()->getAmoCRMSession()) {
                $session = $this->sessionStorage->getActive($method->getUser());
            }

            $cookie = new Cookie('session_id', $session->getId());
            $request = FigRequestCookies::set($request, $cookie);

            $response = $this->httpClient->send($request);
        } catch (SessionDoesNotExistException $e) {
            $this->auth($e->getUser());

            return $this->exec($method);
        } catch (\Exception $e) {
            if ($this->logger) {
                $this->logger->critical('Client error', ['exception' => $e]);
            }

            throw new Exception();
        }

        $methodResponseTransformer = $method->getResponseTransformer();

        if ($methodResponseTransformer) {
            return $methodResponseTransformer->transform($response);
        } elseif ($this->responseTransformer) {
            return $this->responseTransformer->transform($response);
        }

        return $response->getBody()->getContents();
    }

    /**
     * @param UserInterface $user
     * @throws Exception
     */
    private function auth(UserInterface $user)
    {
        $request = new Request(
            'POST', $user->getAmoCRMDomain() . "private/api/auth.php?type=json", [], \GuzzleHttp\json_encode(
                [
                    'USER_LOGIN' => $user->getAmoCRMLogin(),
                    'USER_HASH' => $user->getAmoCRMHash(),
                ]
            )
        );

        $response = $this->httpClient->send($request);
        $cookies = SetCookies::fromResponse($response);
        $sessionCookie = $cookies->get('session_id');

        if ($sessionCookie) {
            $session = new Session($sessionCookie->getValue());
            $user->setAmoCRMSession($session);
            $this->sessionStorage->save($session, $user);
        } else {
            throw new Exception("Session save problem");
        }
    }
}
