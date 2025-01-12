<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use App\Lib\Consts\CacheGrp;
use Cake\Cache\Cache;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

abstract class Api2CommonErrorsTest extends TestCase
{
    use IntegrationTestTrait;

    const ACCESS_TOKEN_SELLER = '555ca191ca768883333c916a0c05bc72bdbbc99';
    const SELLER_ID = '50';

    protected $currentAccessToken = null;

    protected function clearUserCache()
    {
        Cache::clear(CacheGrp::EXTRALONG);
        Cache::delete('_getFirst1', CacheGrp::EXTRALONG);
    }

    abstract protected function _getEndpoint() : string;

    public function setUp(): void
    {
        parent::setUp();
        if (!$this->currentAccessToken) {
            $this->currentAccessToken = self::ACCESS_TOKEN_SELLER;
        }
        $_SERVER['HTTP_ORIGIN'] = 'http://dev.example.com';
        $this->loadAuthToken($this->currentAccessToken);
    }

    protected function loadAuthToken($token)
    {
        $this->configRequest([
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => 'Bearer ' . $token
            ]
        ]);
    }

    public function tearDown(): void
    {
        parent::tearDown();
        unset($_SERVER['HTTP_ORIGIN']);
    }

    protected function assertJsonResponseOK(): array
    {
        $body = (string)$this->_response->getBody();
        $bodyDecoded = json_decode($body, true);
        $this->assertResponseOk($body);
        return $bodyDecoded;
    }

    protected function assertResponseJsonOK($expected)
    {
        $body = (string)$this->_response->getBody();
        $this->assertResponseOk($body);
        $bodyDecoded = json_decode($body, true);
        if ($bodyDecoded) {
            $this->assertEquals($expected, $bodyDecoded);
        } else {
            $expected = json_encode($expected, JSON_PRETTY_PRINT);
            $this->assertEquals($expected, $body);
        }
    }

    protected function assertResponse204NoContent()
    {
        $this->assertEquals(204, $this->_response->getStatusCode());
        $this->assertEquals('', $this->_response->getBody());
    }

    public function testPost_shouldThrowBadRequestExceptionWhenEmptyBodyProvided()
    {
        $this->actionExpectsException('', 'post', 'Empty body or invalid Content-Type in HTTP request');
    }

    public function testPut_shouldThrowBadRequestExceptionWhenNoIdProvided()
    {
        $this->put($this->_getEndpoint(), ['x' => 'y']);

        $body = (string)$this->_response->getBody();
        $this->assertResponseError('HTTP method requires ID' . $body);
        $this->assertEquals('HTTP method requires ID', json_decode($body, true)['message']);
    }

    public function testPut_shouldThrowBadRequestExceptionWhenNoBodyProvided()
    {
        $this->actionExpectsException(self::SELLER_ID, 'put', 'Empty body or invalid Content-Type in HTTP request');
    }

    public function testPatch_shouldThrowBadRequestExceptionWhenNoBodyProvided()
    {
        $this->actionExpectsException(self::SELLER_ID, 'patch', 'Empty body or invalid Content-Type in HTTP request');
    }

    protected function actionExpectsException($url, $method, $message)
    {
        $this->_sendRequest($this->_getEndpoint() . $url, strtoupper($method));
        $body = (string)$this->_response->getBody();
        $this->assertResponseError($body);
        $this->assertEquals($message, json_decode($body, true)['message']);
    }

    public function testPatch_shouldThrowBadRequestExceptionWhenNoIdProvided()
    {
        $this->patch($this->_getEndpoint(), ['x' => 'y']);
        $body = (string)$this->_response->getBody();
        $this->assertResponseError('HTTP method requires ID ' . $body);
        $this->assertEquals('HTTP method requires ID', json_decode($body, true)['message']);
    }

    public function testDelete_shouldThrowBadRequestExceptionWhenNoIdProvided()
    {
        $this->delete($this->_getEndpoint());
        $body = (string)$this->_response->getBody();
        $this->assertResponseError('HTTP method requires ID' . $body);
        $this->assertEquals('HTTP method requires ID', json_decode($body, true)['message']);
    }
}
