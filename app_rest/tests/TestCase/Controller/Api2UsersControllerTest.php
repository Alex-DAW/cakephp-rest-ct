<?php

declare(strict_types=1);

namespace App\Test\TestCase\Controller;

class Api2UsersControllerTest extends Api2CommonErrorsTest
{
    protected $fixtures = [
        'app.Users', 'app.Notebooks'
    ];

    protected function _getEndpoint(): string
    {
        return '/api/v2/users/';
    }

    public function testAddNew_InputData()
    {
        $data = [
            'email' => 'new@example.com',
            'firstname' => 'Alex',
            'lastname' => 'Gomez',
            'password' => 'passpass'
        ];
        $expectedFullName = $data['firstname'] . ' ' . $data['lastname'];
        $this->post($this->_getEndpoint(), $data);

        $this->assertResponseOk($this->_getBodyAsString());
        $return = json_decode($this->_getBodyAsString(), true)['data'];

        $this->assertEquals('new@example.com', $return['email']);
        $this->assertEquals($expectedFullName, $return['full_name']);
    }

    public function testGetData_GetUser1_GetsSingleUser()
    {
        $expectedData = [
            'id' => 1,
            'email' => 'test@example.com',
            'full_name' => 'My Name My Surname',
            'group_id' => 3,
            'created' => '2021-01-18T10:39:23+00:00',
            'modified' => '2021-01-18T10:41:31+00:00',
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
