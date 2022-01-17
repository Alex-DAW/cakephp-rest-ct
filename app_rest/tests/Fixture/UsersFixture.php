<?php

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

class UsersFixture extends TestFixture
{
    public $fields = [
        'id' => ['type' => 'integer'],
        'email' => ['type' => 'string', 'null' => false],
        'firstname' => ['type' => 'string', 'null' => false],
        'lastname' => ['type' => 'string', 'null' => false],
        'password' => ['type' => 'string'],
        'group_id' => ['type' => 'integer'],
        'created' => ['type' => 'datetime'],
        'modified' => ['type' => 'datetime']
    ];

    public $records = [
        [
            'id' => 1,
            'email' => 'test@example.com',
            'firstname' => 'My Name',
            'lastname' => 'My Surname',
            'password' => '$2y$10$1cCayk8qquFFWyvk161qZuOm4kgLFbmg4O1ItVQ5Qt.w3V28VNUk2',
            'group_id' => 3,
            'created' => '2021-01-18 10:39:23',
            'modified' => '2021-01-18 10:41:31'
        ],
    ];
}
