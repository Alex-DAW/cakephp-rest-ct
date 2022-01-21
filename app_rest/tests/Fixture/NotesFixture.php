<?php

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

class NotesFixture extends TestFixture
{
    public $records = [
        [
            'id' => 1,
            'notebook_id' => 1,
            'title' => 'Note 1',
            'date' => '2021-01-20 19:39:23',
            'description' => 'Note test 1',
            'completed' => '2021-01-25 16:39:23',
            'created' => '2021-01-18 10:39:23',
            'modified' => '2021-01-18 10:41:31'
        ],
        [
            'id' => 2,
            'notebook_id' => 2,
            'title' => 'Note from notebook 2',
            'date' => '2021-01-20 19:39:23',
            'description' => 'Note test 2',
            'completed' => '2021-01-25 16:39:23',
            'created' => '2021-01-18 10:39:23',
            'modified' => '2021-01-18 10:41:31'
        ],
    ];
}
