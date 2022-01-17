<?php

namespace App\Controller;

use App\Model\Entity\User;
use App\Model\Table\UsersTable;

/**
 * @property UsersTable $Users
 */
class Api2AuthenticationController extends Api2Controller
{
    public function initialize(): void
    {
        parent::initialize();
        $this->Users = UsersTable::load();
    }

    public function isPublicController(): bool
    {
        return true;
    }

    protected function getMandatoryParams(): array
    {
        return [];
    }

    protected function addNew($data)
    {
        $res = $this->Users->checkLogin($data);

//        $this->
        $this->return = [
            'access_token' => 'sdfgsfg',
            'user' => $res,
        ];
    }

}
