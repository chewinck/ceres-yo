<?php
declare(strict_types=1);

namespace Src\admin\domain;

use Src\admin\domain\User;

 interface UserRepositoryInterface{

    public function saveUser(User $user): void;
    public function listUsers(): array;
    public function searchUserForId(int $userId): ?User;
    public function getAuthenticatedUserWithCiudadano(): ?User;
    
 }