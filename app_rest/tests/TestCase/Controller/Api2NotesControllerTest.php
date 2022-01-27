<?php

declare(strict_types=1);

namespace App\Test\TestCase\Controller;


use App\Model\Table\NotesTable;

class Api2NotesControllerTest extends Api2CommonErrorsTest
{
    public const USER_ID = 1;
    public const NOTEBOOK_ID = 1;

    protected $fixtures = [
        'app.Notes',
        'app.Notebooks',
        'app.Reactions'
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

    public function testAddNew_NonExistingUser()
    {
        $endpoint = '/api/v2/users/300/notebooks/'. self::NOTEBOOK_ID .'/notes/';
        $data = [
            'title'=> 'Note1 user 300',
            'description'=> 'Note1 from the user 3',
            'date'=> '2021-01-20 19:39:23',
            'completed'=> '2021-01-25 16:39:23'
        ];

        $this->post($endpoint, $data);
        $this->assertResponseCode(403);
        $this->assertEquals('UserID does not match notebookID',
            json_decode($this->_getBodyAsString(), true)['message']);
    }

    public function testAddNew_NonExistingNotebook()
    {
        $endpoint = '/api/v2/users/'. self::USER_ID .'/notebooks/877/notes/';
        $data = [
            'title'=> 'Note1 user 300',
	        'description'=> 'Note1 from the user 3',
            'date'=> '2021-01-20 19:39:23',
	        'completed'=> '2021-01-25 16:39:23'
        ];

        $this->post($endpoint, $data);
        $this->assertResponseCode(403);
    }

    public function testGetData_ById()
    {
        $expectedData = [
            'id' => 1,
            'notebook_id' => self::NOTEBOOK_ID,
            'title' => 'Note 1',
            'date' => '2021-01-20T19:39:23+00:00',
            'description' => 'Note test 1',
            'completed' => '2021-01-25T16:39:23+00:00',
            'created' => '2021-01-18T10:39:23+00:00',
            'modified' => '2021-01-18T10:41:31+00:00'
        ];

        $this->get($this->_getEndpoint().'1');

        $this->assertResponseOk($this->_getBodyAsString());
        $return = json_decode($this->_getBodyAsString(), true)['data'];
        $this->assertEquals($expectedData, $return);
    }

    public function testGetData_NonExistingUser()
    {
        $endpoint = '/api/v2/users/400/notebooks/'. self::NOTEBOOK_ID .'/notes/470';
        $this->get($endpoint);
        $this->assertResponseCode(403);
    }

    public function testGetData_NonExistingNotebook()
    {
        $endpoint = '/api/v2/users/'. self::USER_ID .'/notebooks/700/notes/470';
        $this->get($endpoint);
        $this->assertResponseCode(403);
    }

    public function testGetData_NonExistingNote()
    {
        $endpoint = '/api/v2/users/'. self::USER_ID . '/notebooks/'. self::NOTEBOOK_ID .'/notes/470';
        $this->get($endpoint);
        $this->assertResponseCode(404, $this->_getBodyAsString());
        $this->assertEquals('Record not found in table "notes"',
            json_decode($this->_getBodyAsString(), true)['message']);
    }

    public function testGetList_FromNotebook1()
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

    public function testGetList_NonExistingUser()
    {
        $endpoint = '/api/v2/users/800/notebooks/'. self::NOTEBOOK_ID .'/notes/';
        $this->get($endpoint);
        $this->assertResponseCode(403);
    }

    public function testGetList_NonExistingNotebook()
    {
        $endpoint = '/api/v2/users/'. self::USER_ID .'/notebooks/300/notes/';
        $this->get($endpoint);
        $this->assertResponseCode(403);
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

    public function testEdit_editNonExistingUser()
    {
        $endpoint = '/api/v2/users/600/notebooks/' . self::NOTEBOOK_ID. '/notes/1';
        $data = [
            'title' => 'Note 1, Modificación',
            'description' => 'Modificando la nota'
        ];
        $this->patch($endpoint, $data);
        $this->assertResponseCode(403);
    }

    public function testEdit_editNonExistingNotebook()
    {
        $endpoint = '/api/v2/users/'. self::USER_ID .'/notebooks/70/notes/1';
        $data = [
            'title' => 'Note 1, Modificación',
            'description' => 'Modificando la nota'
        ];
        $this->patch($endpoint, $data);
        $this->assertResponseCode(403);
    }

    public function testEdit_editNonExistingNote()
    {
        $data = [
            'title' => 'Note 1, Modificación',
            'description' => 'Modificando la nota'
        ];
        $this->patch($this->_getEndpoint().'900', $data);
        $this->assertResponseCode(404);
    }


    public function testDelete_DeleteNote1()
    {
        $noteId = 1;
        $this->delete($this->_getEndpoint() . $noteId);
        $this->assertResponseOk($this->_getBodyAsString());

        $note = NotesTable::load()->findNotesByNotebook($noteId)->first();

        $this->assertNull($note);
    }

    public function testDelete_DeleteNonExistingUser()
    {
        $endpoint = '/api/v2/users/565/notebooks/' . self::NOTEBOOK_ID. '/notes/1';
        $this->delete($endpoint);
        $this->assertResponseCode(403);
    }

    public function testDelete_DeleteNonExistingNotebook()
    {
        $endpoint = '/api/v2/users/'. self::USER_ID .'/notebooks/700/notes/1';
        $this->delete($endpoint);
        $this->assertResponseCode(403);
    }

    public function testDelete_NonExistingNote15_Exception()
    {
        $noteId = 15;
        $this->delete($this->_getEndpoint() . $noteId);
        $this->assertResponseError($this->_getBodyAsString());
    }
}
