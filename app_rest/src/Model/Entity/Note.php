<?php

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * @property mixed $notebook_id
 * @property string $title
 * @property mixed $date
 * @property string $description
 * @property mixed $completed
 */
class Note extends Entity
{

    protected $_accessible = [
        '*' => false,
        'id' => false,

        'title' => true,
        'date' => true,
        'description' => true,
        'completed' => true,
    ];

    protected $_hidden = [
        'deleted'
    ];

}
