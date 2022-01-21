<?php

declare(strict_types=1);

namespace App\Test\TestCase\Controller;


use App\Model\Table\NotesTable;

class Api2NotesControllerTest extends Api2CommonErrorsTest
{
    public const USER_ID = 1;
    public const NOTEBOOK_ID = 1;

    protected $fixtures = [
        'app.Notes'
    ];

    protected function _getEndpoint(): string
    {
        return '/api/v2/users/' . self::USER_ID . '/notebooks/' . self::NOTEBOOK_ID. '/notes/';
    }

    public function testAddNew_Note()
    {
        $data = [
            'title' => 'Note 1',
            'description' => 'Note test 1',
            'date' => '2021-01-20 19:39:23',
            'completed' => '2021-01-25 16:39:23'
        ];

        $expected = [
            'id' => 3,
            'notebook_id' => self::NOTEBOOK_ID,
            'title' => 'Note 1',
            'date' => '2021-01-20T19:39:23+00:00',
            'description' => 'Note test 1',
            'completed' => '2021-01-25T16:39:23+00:00'
        ];

        $this->post($this->_getEndpoint(), $data);

        $this->assertResponseOk($this->_getBodyAsString());
        $return = json_decode($this->_getBodyAsString(), true)['data'];
        unset($return['created']);
        unset($return['modified']);
        $this->assertEquals($expected, $return);
    }

    public function testGetNote1_ById()
    {
        $expectedData = [
            [
            'id' => 1,
            'notebook_id' => self::NOTEBOOK_ID,
            'title' => 'Note 1',
            'date' => '2021-01-20T19:39:23+00:00',
            'description' => 'Note test 1',
            'completed' => '2021-01-25T16:39:23+00:00',
            'created' => '2021-01-18T10:39:23+00:00',
            'modified' => '2021-01-18T10:41:31+00:00'
            ]
        ];

        $this->get($this->_getEndpoint().'1');

        $this->assertResponseOk($this->_getBodyAsString());
        $return = json_decode($this->_getBodyAsString(), true)['data'];
        $this->assertEquals($expectedData, $return);
    }

    public function testGetNotes_FromNotebook1()
    {
        $expectedData = [
            [
            'id' => 1,
            'notebook_id' => self::NOTEBOOK_ID,
            'title' => 'Note 1',
            'date' => '2021-01-20T19:39:23+00:00',
            'description' => 'Note test 1',
            'completed' => '2021-01-25T16:39:23+00:00',
            'created' => '2021-01-18T10:39:23+00:00',
            'modified' => '2021-01-18T10:41:31+00:00'
            ]
        ];

        $this->get($this->_getEndpoint());

        $this->assertResponseOk($this->_getBodyAsString());
        $return = json_decode($this->_getBodyAsString(), true)['data'];
        $this->assertEquals($expectedData, $return);
    }

    public function testEdit_editNote1ChangeTitle_Description()
    {
        $data = [
            'title' => 'Note 1, Modificación',
            'description' => 'Modificando la nota'
        ];

        $this->patch($this->_getEndpoint() . '1', $data);
        $this->assertResponseOk($this->_getBodyAsString());
        $return = json_decode($this->_getBodyAsString(), true)['data'];
        $this->assertEquals($data['title'], $return['title']);
        $this->assertEquals($data['description'], $return['description']);
    }


    public function testDelete_DeletesNote1()
    {
        $noteId = 1;
        $this->delete($this->_getEndpoint() . $noteId);
        $this->assertResponseOk($this->_getBodyAsString());

        $note = NotesTable::load()->findById($noteId)->first();

        $this->assertNull($note);
    }

    public function testDelete_NonExistingNote15_Exception()
    {
        $noteId = 15;
        $this->delete($this->_getEndpoint() . $noteId);
        $this->assertResponseError($this->_getBodyAsString());
    }
}
