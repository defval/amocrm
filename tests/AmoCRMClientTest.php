<?php
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use mb24dev\AmoCRM\Exception;
use mb24dev\AmoCRM\Method\MethodInterface;
use mb24dev\AmoCRM\ResponseTransformer\ResponseTransformerInterface;
use mb24dev\AmoCRM\Session\Session;
use mb24dev\AmoCRM\Session\SessionDoesNotExistException;
use mb24dev\AmoCRM\Session\SessionDoNotSavedException;
use mb24dev\AmoCRM\SessionStorage\SessionStorageInterface;
use mb24dev\AmoCRM\User\User;

/**
 * Class AmoCRMClientTest
 */
class AmoCRMClientTest extends PHPUnit_Framework_TestCase
{

    /** @var  ClientInterface|PHPUnit_Framework_MockObject_MockObject */
    private $client;

    /** @var  SessionStorageInterface|PHPUnit_Framework_MockObject_MockObject */
    private $sessionStorage;

    /** @var  ResponseTransformerInterface|PHPUnit_Framework_MockObject_MockObject */
    private $responseTransformer;

    private function validSessionStorage()
    {
        $this->sessionStorage->method('save')->willReturn(null);
        $this->sessionStorage->method('getActive')->willReturn(new Session('session_id'));
    }

    private function invalidSessionStorage()
    {
        $this->sessionStorage->method('save')->willThrowException(new SessionDoNotSavedException());
        $this->sessionStorage->method('getActive')->willThrowException(
            new SessionDoesNotExistException(new User('domain', 'login', 'hash'))
        );
    }

    /**
     * Sets up the fixture, for example, open a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->client = $this->getMockForAbstractClass(ClientInterface::class);
        $this->client->method('send')->willReturn(
            new Response(200)
        );

        $this->sessionStorage = $this->getMockForAbstractClass(
            SessionStorageInterface::class
        );

        $this->responseTransformer = $this->getMockForAbstractClass(ResponseTransformerInterface::class);
        $this->responseTransformer->method(
            'transform'
        )->willReturn([]);
    }

    public function testExecAbstractMethod()
    {
        $this->validSessionStorage();
        $amoCRMClient = new \mb24dev\AmoCRM\AmoCRMClient(
            $this->client, $this->sessionStorage, $this->responseTransformer
        );

        $method = $this->getMockForAbstractClass(MethodInterface::class);
        $method->method('getUser')->willReturn(
            new User('domain', 'login', 'hash')
        );

        $method->method('buildRequest')->willReturn(new Request('post', 'url'));
        $method->method('getResponseTransformer')->willReturn(null);

        $this->assertEquals([], $amoCRMClient->exec($method));
    }

    public function testSessionException()
    {
        $this->invalidSessionStorage();
        $amoCRMClient = new \mb24dev\AmoCRM\AmoCRMClient(
            $this->client, $this->sessionStorage, $this->responseTransformer
        );

        $method = $this->getMockForAbstractClass(MethodInterface::class);
        $method->method('getUser')->willReturn(
            new User('domain', 'login', 'hash')
        );

        $method->method('buildRequest')->willReturn(new Request('post', 'url'));
        $method->method('getResponseTransformer')->willReturn(null);
        $this->expectException(Exception::class);
        $amoCRMClient->exec($method);
    }

}
