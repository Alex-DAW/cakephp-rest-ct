<?php

declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use App\Model\Table\ReactionsTable;

class Api2ReactionsControllerTest extends Api2CommonErrorsTest
{
    public const USER_ID = 1;
    public const NOTEBOOK_ID = 1;
    public const NOTE_ID = 1;


    protected $fixtures = [
        'app.Reactions',
        'app.Notes',
        'app.Notebooks'
    ];

    protected function _getEndpoint(): string
    {
        return '/api/v2/users/' . self::USER_ID . '/notebooks/' . self::NOTEBOOK_ID. '/notes/'. self::NOTE_ID .'/reactions/';
    }

    public function testAddNew_Reaction()
    {
        $data = [
            'emoji' => ':D'
        ];

        $expected = [
            'id' => 2,
            'note_id' => self::NOTE_ID,
            'emoji' => ':D'
        ];

        $this->post($this->_getEndpoint(), $data);
        $this->assertResponseOk($this->_getBodyAsString());
        $return = json_decode($this->_getBodyAsString(), true)['data'];

        $this->assertEquals($expected, $return);
    }

    public function testAddNew_NonExistingUser()
    {
       $endpoint = '/api/v2/users/30000/notebooks/' . self::NOTEBOOK_ID. '/notes/'. self::NOTE_ID .'/reactions';
       $data = [
           'emoji' => ':D'
       ];
        $this->post($endpoint, $data);
        $this->assertResponseCode(403);
    }

    public function testAddNew_NonExistingNotebook()
    {
        $endpoint = '/api/v2/users/'. self::USER_ID .'/notebooks/40000/notes/'. self::NOTE_ID .'/reactions';
        $data = [
            'emoji' => ':D'
        ];
        $this->post($endpoint, $data);
        $this->assertResponseCode(403);
    }

    public function testAddNew_NonExistingNote()
    {
        $endpoint = '/api/v2/users/'. self::USER_ID .'/notebooks/'. self::NOTEBOOK_ID.'/notes/50000/reactions';
        $data = [
            'emoji' => ':D'
        ];
        $this->post($endpoint, $data);
        $this->assertResponseCode(403);
    }

    public function testGetData_ReactionById1()
    {
        $expectedData = [
            'id' => 1,
            'note_id' => self::NOTE_ID,
            'emoji' => ':D'
        ];

        $this->get($this->_getEndpoint(). '1');
        $this->assertResponseOk($this->_getBodyAsString());
        $return = json_decode($this->_getBodyAsString(), true)['data'];
        $this->assertEquals($expectedData, $return);
    }

    public function testGetData_NonExistingUser()
    {
        $endpoint = '/api/v2/users/30000/notebooks/' . self::NOTEBOOK_ID. '/notes/'. self::NOTE_ID .'/reactions/1';

        $this->get($endpoint);
        $this->assertResponseCode(403);
    }

    public function testGetData_NonExistingNotebook()
    {
        $endpoint = '/api/v2/users/'. self::USER_ID .'/notebooks/40000/notes/'. self::NOTE_ID .'/reactions/1';

        $this->get($endpoint);
        $this->assertResponseCode(403);
    }

    public function testGetData_NonExistingNote()
    {
        $endpoint = '/api/v2/users/'. self::USER_ID .'/notebooks/'. self::NOTEBOOK_ID.'/notes/50000/reactions/1';

        $this->get($endpoint);
        $this->assertResponseCode(403);
    }

    public function testGetData_NonExistingReaction()
    {
        $endpoint = $this->_getEndpoint().'100';

        $this->get($endpoint);
        $this->assertResponseCode(404);
    }

    public function testGetList_FromReaction1()
    {
        $expectedData = [
            [
            'id' => 1,
            'note_id' => self::NOTE_ID,
            'emoji' => ':D'
            ]
        ];

        $this->get($this->_getEndpoint());

        $this->assertResponseOk($this->_getBodyAsString());
        $return = json_decode($this->_getBodyAsString(), true)['data'];
        $this->assertEquals($expectedData, $return);
    }

    public function testGetList_FromNonExistingUser()
    {
        $endpoint = '/api/v2/users/30000/notebooks/' . self::NOTEBOOK_ID. '/notes/'. self::NOTE_ID .'/reactions';

        $this->get($endpoint);
        $this->assertResponseCode(403);
    }

    public function testGetList_FromNonExistingNotebook()
    {
        $endpoint = '/api/v2/users/'. self::USER_ID .'/notebooks/40000/notes/'. self::NOTE_ID .'/reactions';

        $this->get($endpoint);
        $this->assertResponseCode(403);
    }

    public function testGetList_FromNonExistingNote()
    {
        $endpoint = '/api/v2/users/'. self::USER_ID .'/notebooks/'. self::NOTEBOOK_ID.'/notes/50000/reactions';

        $this->get($endpoint);
        $this->assertResponseCode(403);
    }

    public function testDelete_DeleteReaction1()
    {
        $reactionId = 1;
        $this->delete($this->_getEndpoint(). $reactionId);
        $this->assertResponseOk($this->_getBodyAsString());

        $reaction = ReactionsTable::load()->findReactionsByNoteId($reactionId)->first();

        $this->assertNull($reaction);
    }

    public function testDelete_FromNonExistingUser()
    {
        $endpoint = '/api/v2/users/30000/notebooks/' . self::NOTEBOOK_ID. '/notes/'. self::NOTE_ID .'/reactions/1';

        $this->delete($endpoint);
        $this->assertResponseCode(403);
    }

    public function testDelete_FromNonExistingNotebook()
    {
        $endpoint = '/api/v2/users/'. self::USER_ID .'/notebooks/40000/notes/'. self::NOTE_ID .'/reactions/1';

        $this->get($endpoint);
        $this->assertResponseCode(403);
    }

    public function testDelete_FromNonExistingNote()
    {
        $endpoint = '/api/v2/users/'. self::USER_ID .'/notebooks/'. self::NOTEBOOK_ID.'/notes/50000/reactions/1';

        $this->delete($endpoint);
        $this->assertResponseCode(403);
    }

    public function testDelete_FromNonExistingReaction()
    {
        $endpoint = '/api/v2/users/'. self::USER_ID .'/notebooks/'. self::NOTEBOOK_ID.'/notes/'. self::NOTE_ID .'/reactions/1000';

        $this->delete($endpoint);
        $this->assertResponseCode(404);
    }
}
