<?php
declare(strict_types=1);

namespace Src\domain;

use Src\domain\UserEntity;

 interface UserRepository{

    public function saveUser(UserEntity $user): void;
    public function listUsers(): array;
    public function searchUserForId(int $userId): ?UserEntity;
    
 }