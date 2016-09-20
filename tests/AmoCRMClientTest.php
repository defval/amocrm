<?php
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use mb24dev\AmoCRM\AmoCRMException;
use mb24dev\AmoCRM\HttpClient\HttpClientInterface;
use mb24dev\AmoCRM\Method\MethodInterface;
use mb24dev\AmoCRM\ResponseTransformer\ResponseTransformerInterface;
use mb24dev\AmoCRM\Session\Session;
use mb24dev\AmoCRM\Session\SessionDoesNotExistException;
use mb24dev\AmoCRM\SessionStorage\SessionStorageInterface;
use mb24dev\AmoCRM\User\User;
use mb24dev\AmoCRM\User\UserInterface;

/**
 * Class AmoCRMClientTest
 */
class AmoCRMClientTest extends PHPUnit_Framework_TestCase
{

    const SESSION_ID = 'session_hash';
    const USER_DOMAIN = 'domain';
    const USER_LOGIN = 'login';
    const USER_HASH = 'hash';

    /**
     * @var  HttpClientInterface|PHPUnit_Framework_MockObject_MockObject
     */
    private $client;

    /**
     * @var UserInterface
     */
    private $user;

    /**
     * @return PHPUnit_Framework_MockObject_MockObject|SessionStorageInterface
     */
    private function getSessionStorage()
    {
        return $this->getMockForAbstractClass(SessionStorageInterface::class);
    }

    /**
     * @return PHPUnit_Framework_MockObject_MockObject|ResponseTransformerInterface
     */
    private function getResponseTransformer()
    {
        return $this->getMockForAbstractClass(ResponseTransformerInterface::class);
    }

    /**
     * Sets up the fixture, for example, open a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->user = new User(self::USER_DOMAIN, self::USER_LOGIN, self::USER_HASH);
        $this->client = $this->getMockForAbstractClass(HttpClientInterface::class);
        $this->client->method('send')->willReturn(
            new Response(200, ['Set-Cookie' => 'session_id=' . self::SESSION_ID])
        );
    }

    public function testExecAbstractMethod()
    {
        $sessionStorage = $this->getSessionStorage();
        $sessionStorage->expects($this->never())->method('save');
        $sessionStorage->expects($this->once())->method('getActive')->willReturn(new Session(self::SESSION_ID));

        $responseTransformer = $this->getResponseTransformer();
        $responseTransformer->expects($this->once())->method('transform')->willReturn('transformed');

        $amoCRMClient = new \mb24dev\AmoCRM\AmoCRMClient(
            $this->client, $sessionStorage, $responseTransformer
        );

        $method = $this->getMockForAbstractClass(MethodInterface::class);
        $method->method('getUser')->willReturn($this->user);

        $method->method('buildRequest')->willReturn(new Request('post', 'url'));
        $method->method('getResponseTransformer')->willReturn(null);

        $this->assertEquals('transformed', $amoCRMClient->exec($method), 'Message must be transform');
    }

    public function testClientSendAuthRequest()
    {
        $sessionStorage = $this->getSessionStorage();

        $sessionStorage->expects($this->once())->method('getActive')->willThrowException(
            new SessionDoesNotExistException($this->user)
        );
        $sessionStorage->expects($this->once())->method('save');

        $responseTransformer = $this->getResponseTransformer();
        $responseTransformer->expects($this->once())->method('transform')->willReturn('transformed');

        $amoCRMClient = new \mb24dev\AmoCRM\AmoCRMClient(
            $this->client, $sessionStorage, $responseTransformer
        );

        $this->client->expects($this->exactly(2))->method('send');

        $method = $this->getMockForAbstractClass(MethodInterface::class);
        $method->method('getUser')->willReturn($this->user);
        $method->method('buildRequest')->willReturn(new Request('post', 'url'));

        $this->assertEquals('transformed', $amoCRMClient->exec($method), 'Message must be transform');
    }

    public function testSessionNotSavedException()
    {
        $this->expectException(AmoCRMException::class);
        $sessionStorage = $this->getSessionStorage();

        $sessionStorage->expects($this->once())->method('getActive')->willThrowException(
            new SessionDoesNotExistException($this->user)
        );

        $sessionStorage->expects($this->once())->method('save')->willThrowException(
            new \mb24dev\AmoCRM\Session\SessionDoNotSavedException()
        );

        $responseTransformer = $this->getResponseTransformer();
        $responseTransformer->expects($this->never())->method('transform')->willReturn('transformed');

        $amoCRMClient = new \mb24dev\AmoCRM\AmoCRMClient(
            $this->client, $sessionStorage, $responseTransformer
        );

        $method = $this->getMockForAbstractClass(MethodInterface::class);
        $method->method('getUser')->willReturn($this->user);
        $method->method('buildRequest')->willReturn(new Request('post', 'url'));

        $amoCRMClient->exec($method);
    }

    public function testUserTransformerHaveMorePriority()
    {
        $sessionStorage = $this->getSessionStorage();

        $sessionStorage->expects($this->once())->method('getActive')->willReturn(new Session(self::SESSION_ID));
        $sessionStorage->expects($this->never())->method('save');

        $responseTransformer = $this->getResponseTransformer();

        $methodResponseTransformer = $this->getResponseTransformer();
        $methodResponseTransformer->expects($this->once())->method('transform')->willReturn('transformed by method');

        $amoCRMClient = new \mb24dev\AmoCRM\AmoCRMClient(
            $this->client, $sessionStorage, $responseTransformer
        );

        $this->client->expects($this->once())->method('send');

        $method = $this->getMockForAbstractClass(MethodInterface::class);
        $method->method('getUser')->willReturn($this->user);
        $method->expects($this->once())->method('buildRequest')->willReturn(new Request('post', 'url'));
        $method->expects($this->once())->method('getResponseTransformer')->willReturn($methodResponseTransformer);

        $this->assertEquals('transformed by method', $amoCRMClient->exec($method), 'Message must be transform');
    }
}
