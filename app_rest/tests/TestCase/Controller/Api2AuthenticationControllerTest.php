<?php

declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use App\Model\Table\UsersTable;

class Api2AuthenticationControllerTest extends Api2CommonErrorsTest
{
    protected $fixtures = ['app.Users'];


    protected function _getEndpoint(): string
    {
        return '/api/v2/authentication/';
    }

    public function setUp(): void
    {
        parent::setUp();
        UsersTable::load();
    }

    public function testAddNew_login()
    {
        $data = [
            'email'=> 'test@example.com',
            'password'=> 'passpass'
        ];

        $this->post($this->_getEndpoint(), $data);

        $this->assertResponseOk($this->_getBodyAsString());
        $return = json_decode($this->_getBodyAsString(), true)['data'];

        debug($return);
        $this->assertArrayHasKey('access_token', $return);
    }

}
