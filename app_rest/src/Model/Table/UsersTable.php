<?php

namespace App\Model\Table;

use App\Lib\Consts\CacheGrp;
use App\Model\Entity\User;
use Cake\Auth\DefaultPasswordHasher;
use Cake\Http\Exception\BadRequestException;
use Cake\Http\Exception\UnauthorizedException;
use Cake\ORM\TableRegistry;

class UsersTable extends AppTable
{


    public static function load(): UsersTable
    {
        /** @var UsersTable $table */
        $table = TableRegistry::getTableLocator()->get('Users');
        return $table;
    }

    public function initialize(array $config): void
    {
        $this->addBehavior('Timestamp');
        $this->hasMany('Notebooks');
    }

    public function getDependentUserIDs($uID): array
    {
        return []; // $this->AdminUsers->getDependentUserIDs($uID);
    }

    private function _getFirst($uid): User
    {
        return $this->findById($uid)
            ->cache('_getFirst' . $uid, CacheGrp::EXTRALONG)
            ->firstOrFail();
    }

    public function getUserGroup($uid): ?int
    {
        $u = $this->_getFirst($uid);
        return $u->group_id ?? null;
    }

    public function checkLogin(array $data)
    {
        $email = $data['email'] ?? '';
        if (!$email) {
            throw new BadRequestException('Email is required');
        }
        $pass = $data['password'] ?? '';
        if (!$pass) {
            throw new BadRequestException('Password is required');
        }
        /** @var User $usr */
        $usr = $this->find()
            ->where(['email' => $email])
            ->first();
        if (!$usr) {
            throw new UnauthorizedException('User not found');
        }
        if (!(new DefaultPasswordHasher)->check($pass, $usr->password)) {
            throw new UnauthorizedException('Invalid password');
        }
        return $usr;
    }
}
