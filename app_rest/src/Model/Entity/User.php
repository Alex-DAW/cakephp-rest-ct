<?php

namespace App\Model\Entity;

use Cake\Auth\DefaultPasswordHasher;
use Cake\I18n\FrozenTime;
use Cake\ORM\Entity;

/**
 * @property string firstname
 * @property string lastname
 * @property string email
 * @property mixed group_id
 * @property mixed $password
 * @property mixed $created
 * @property mixed $modified
 */
class User extends Entity
{
    public function __construct(array $properties = [], array $options = [])
    {
        parent::__construct($properties, $options);
    }

    protected $_accessible = [
        '*' => false,
        'id' => false,

        'password' => true,
        'email' => true,
        'firstname' => true,
        'lastname' => true,
    ];

    protected $_hidden = [
        'deleted',
        'firstname',
        'lastname',
        'password',
    ];

    protected $_virtual = [
        'full_name',
    ];

    protected function _setPassword($password)
    {
        if (strlen($password) > 0) {
            return (new DefaultPasswordHasher)->hash($password);
        }
    }

    protected function _getFullName(): string
    {
        return $this->firstname . ' ' . $this->lastname;
    }

    protected function _getCreated(): string
    {
        $frozenTime = new FrozenTime($this->_fields['created']);
        return $frozenTime->format('d-m-Y');
    }

    protected function _getModified(): string
    {
        $frozenTime = new FrozenTime($this->_fields['modified']);
        return $frozenTime->format('d-m-Y');
    }
}
