<?php

declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use App\Model\Table\UsersTable;
use Cake\I18n\FrozenTime;

class Api2UsersControllerTest extends Api2CommonErrorsTest
{
    protected $fixtures = [
        'app.Users'
    ];

    protected function _getEndpoint(): string
    {
        return '/api/v2/users/';
    }

    public function testAddNew_InputData()
    {
        $data = [
            'email'=> 'test@example.com',
            'firstname'=> 'Alex',
            'lastname'=> 'Gomez',
            'password'=> 'passpass'
        ];

        $this->post($this->_getEndpoint(), $data);

        $this->assertResponseOk($this->_getBodyAsString());
        $return = json_decode($this->_getBodyAsString(), true)['data'];

        $this->assertEquals('test@example.com', $return['email']);
        $this->assertEquals('Alex', $return['firstname']);
        $this->assertEquals('Gomez', $return['lastname']);
        $this->assertStringStartsWith('$2y$10$', $return['password']);
    }

    public function testGetData_GetUser1_GetsSingleUser()
    {
        $expectedData = [
            'id' => 1,
            'email' => 'test@example.com',
            'full_name' => 'My Name My Surname',
            'group_id' => 3,
            'created' => '18-01-2021',
            'modified' => '18-01-2021',
            'notebooks' => [
                [
                    'id' => 1,
                    'user_id' => 1,
                    'title' => 'Título 1',
                    'shape' => 'TODO',
                    'created' => '2021-01-18T10:39:23+00:00',
                    'modified' => '2021-01-18T10:41:31+00:00'
                ]
            ]
        ];

        $this->get($this->_getEndpoint() . 1);

        $this->assertResponseOk($this->_getBodyAsString());
        $return = json_decode($this->_getBodyAsString(), true)['data'];
        $this->assertEquals($expectedData, $return);
    }
}
