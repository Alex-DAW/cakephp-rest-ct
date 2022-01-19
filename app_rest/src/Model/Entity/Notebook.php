<?php

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * @property string $title
 * @property mixed $user_id
 * @property string $shape
 * @property mixed $created
 * @property mixed $modified
 */
class Notebook extends Entity
{
    public function __construct(array $properties = [], array $options = [])
    {
        parent::__construct($properties, $options);
    }

    protected $_accessible = [
        '*' => false,
        'id' => false,
        'user_id' => false,

        'title' => true,
        'shape' => true,
        'created' => true,
        'modified' => true,
    ];

    protected $_hidden = [
        'deleted'
    ];

    protected $_virtual = [

    ];

}
