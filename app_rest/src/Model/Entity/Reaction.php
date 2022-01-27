<?php

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * @property mixed $user_id
 * @property mixed $note_id
 * @property string emoji
 */
class Reaction extends Entity
{
    protected $_accessible = [
        '*' => false,
        'id' => false,

        'emoji' => true,
    ];

    protected $_hidden = [
        'deleted',
        'created',
        'modified'
    ];
}
