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
        'app.Notes'
    ];

    protected function _getEndpoint(): string
    {
        return '/api/v2/users/' . self::USER_ID . '/notebooks/' . self::NOTEBOOK_ID. '/notes/'. self::NOTE_ID .'/emojis';
    }

    public function testAddNew_Emoji()
    {

    }

    public function testGetData_EmojiById()
    {

    }

    public function testGetList_FromNote1()
    {

    }

    public function testEdit_editEmoji1ChangeEmoji()
    {

    }

    public function testDelete_DeleteEmoji1()
    {

    }
}
