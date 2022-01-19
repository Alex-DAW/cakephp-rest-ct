<?php

declare(strict_types=1);

namespace App\Test\TestCase\Controller;

class Api2NotebookControllerTest extends Api2CommonErrorsTest
{
    public const USERID = 1;

    protected $fixtures = [
        'app.Notebooks'
    ];

    protected function _getEndpoint(): string
    {
        return '/api/v2/users/' . self::USERID . '/notebooks/';
    }

    public function testAddNew_InputData()
    {
        $data = [
            'title' => 'Título 1',
            'shape' => 'TODO'
        ];

        $expected = [
            'id' => 2,
            'user_id' => 1,
            'title' => 'Título 1',
            'shape' => 'TODO',
        ];

        $this->post($this->_getEndpoint(), $data);

        $this->assertResponseOk($this->_getBodyAsString());
        $return = json_decode($this->_getBodyAsString(), true)['data'];
        unset($return['created']);
        unset($return['modified']);
        $this->assertEquals($expected, $return);
    }

    public function testGetList_GetUser1_GetsSingleUser()
    {
        $expectedData = [
            [
                'id' => 1,
                'user_id' => 1,
                'title' => 'Título 1',
                'shape' => 'TODO',
                'created' => '2021-01-18T10:39:23+00:00',
                'modified' => '2021-01-18T10:41:31+00:00'
            ]
        ];

        $this->get($this->_getEndpoint());

        $this->assertResponseOk($this->_getBodyAsString());
        $return = json_decode($this->_getBodyAsString(), true)['data'];
        $this->assertEquals($expectedData, $return);
    }
}
