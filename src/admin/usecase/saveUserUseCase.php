<?php

declare(strict_types=1);

namespace Src\admin\usecase;

use Src\admin\domain\UserRepositoryInterface;
use Src\shared\response\ResponseHttp;

final class saveUserUseCase{

    public function __construct(
        private UserRepositoryInterface $repository){
    }

    public function execute(): ResponseHttp {
        $users = $this->repository->listUsers();
        return new ResponseHttp(200, " Se ha obtenido la Lista de usuarios satisfactoriamente", $users);
    }
}